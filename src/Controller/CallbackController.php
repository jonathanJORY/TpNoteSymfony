<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CallbackController extends AbstractController
{
    /**
     * @Route("/callback", name="callback")
     */
    public function index(Request $request): Response
    {
        // Récupérer le jeton d'accès depuis le fragment de l'URL
        return $this->render('callback/index.html.twig', [
            'controller_name' => 'CallbackController',
        ]);
    }
}
