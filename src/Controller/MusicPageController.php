<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MusicPageController extends AbstractController
{
    /**
     * @Route("/music-page", name="music_page")
     */
    public function index(): Response
    {
        return $this->render('music_page/index.html.twig');
    }
}
