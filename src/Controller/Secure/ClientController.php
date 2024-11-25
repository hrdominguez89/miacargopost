<?php

namespace App\Controller\Secure;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    #[Route('/secure/client', name: 'app_secure_client')]
    public function index(): Response
    {
        return $this->render('secure/client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }
}
