<?php

namespace App\Controller;

use App\Entity\Track;

use App\Entity\Album;
use App\Controller\AlbumController;

use App\Form\TrackType;
use App\Repository\TrackRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/track')]
class TrackController extends AbstractController
{
    #[Route('/{albumid}', name: 'app_track_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager, $albumid): Response
    {
        $albumid = intval($albumid);
        $albums = $entityManager
            ->getRepository(Album::class)
            ->findAll();
        $album = $entityManager->getRepository(Album::class)->find($albumid);

        $tracks = $album->getTracks();
        return $this->render('track/index.html.twig', [
            'tracks' => $tracks,
            'album' => $album,
            'albums' => $albums
        ]);
    }

    #[Route('/new/{albumid}', name: 'app_track_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TrackRepository $trackRepository, Album $albumid): Response
    {
        
        $track = new Track();
        if(is_null($track->getAlbum())){
            $track->setAlbum($albumid);
        }
        $form = $this->createForm(TrackType::class, $track);
        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) {
            $trackRepository->save($track, true);

            return $this->redirectToRoute('app_track_index', array('albumid'=> $track->getAlbum()->getId()), Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('track/new.html.twig', [
            'track' => $track,
            'form' => $form,
            'album' => $albumid,
        ]);
    }

    #[Route('/{id}', name: 'app_track_show', methods: ['GET'])]
    public function show(Track $track): Response
    {
        return $this->render('track/show.html.twig', [
            'track' => $track,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_track_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Track $track, TrackRepository $trackRepository): Response
    {
        $form = $this->createForm(TrackType::class, $track);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trackRepository->save($track, true);

            return $this->redirectToRoute('app_track_index', array('albumid'=> $track->getAlbum()->getId()), Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('track/edit.html.twig', [
            'track' => $track,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_track_delete', methods: ['POST'])]
    public function delete(Request $request, Track $track, TrackRepository $trackRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$track->getId(), $request->request->get('_token'))) {
            $trackRepository->remove($track, true);
        }

        return $this->redirectToRoute('app_track_index',  array('albumid'=> $track->getAlbum()->getId()), Response::HTTP_SEE_OTHER);
    }
}
