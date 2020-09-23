<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class OurClientsController extends AbstractController
{
    /**
     * @Route("/nos-clients", name="app_our_clients")
     */
    public function index()
    {
        return $this->render('our_clients/index.html.twig', [
            'controller_name' => 'OurClientsController',
        ]);
    }
}
