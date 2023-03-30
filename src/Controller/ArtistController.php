<?php

namespace App\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Artist;
use App\Form\ArtistType;
use App\Repository\ArtistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/artist')]
class ArtistController extends AbstractController
{
    #[Route('/', name: 'app_artist_index', methods: ['GET'])]
    public function index(ArtistRepository $artistRepository): Response
    {
        return $this->render('artist/index.html.twig', [
            'artists' => $artistRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_artist_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ArtistRepository $artistRepository): Response
    {
        $artist = new Artist();
        $form = $this->createForm(ArtistType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $artistRepository->save($artist, true);

            return $this->redirectToRoute('app_artist_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('artist/new.html.twig', [
            'artist' => $artist,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_artist_show', methods: ['GET'])]
    public function show(Artist $artist): Response
    {
        return $this->render('artist/show.html.twig', [
            'artist' => $artist,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_artist_edit', methods: ['GET', 'POST'])]
public function edit(Request $request, Artist $artist, ArtistRepository $artistRepository): Response
{
    // 1. Créer une copie de la collection des genres existants de l'artiste
    $originalGenres = new ArrayCollection();
    foreach ($artist->getGenres() as $genre) {
        $originalGenres->add($genre);
    }

    $form = $this->createForm(ArtistType::class, $artist);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // 2. Supprimer les relations de genre non présentes dans le formulaire
        foreach ($originalGenres as $genre) {
            if (!$artist->getGenres()->contains($genre)) {
                $artist->removeGenre($genre);
            }
        }

        // 3. Ajouter les nouvelles relations de genre à partir du formulaire
        foreach ($artist->getGenres() as $genre) {
            if (!$originalGenres->contains($genre)) {
                $artist->addGenre($genre);
            }
        }

        // 4. Persister et envoyer les modifications à la base de données
        $artistRepository->save($artist, true);

        return $this->redirectToRoute('app_artist_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('artist/edit.html.twig', [
        'artist' => $artist,
        'form' => $form,
    ]);
}


    #[Route('/{id}', name: 'app_artist_delete', methods: ['POST'])]
    public function delete(Request $request, Artist $artist, ArtistRepository $artistRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$artist->getId(), $request->request->get('_token'))) {
            $artistRepository->remove($artist, true);
        }

        return $this->redirectToRoute('app_artist_index', [], Response::HTTP_SEE_OTHER);
    }
}
