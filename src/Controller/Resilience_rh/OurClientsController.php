<?php

namespace App\Controller\Resilience_rh;

use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class OurClientsController extends AbstractController
{
    /**
     * @Route("/nos-clients", name="app_our_clients")
     */
    public function index(ClientRepository $repo)
    {
        return $this->render('our_clients/index.html.twig', ['clients' => $repo->findBy([], ['createdAt' => 'DESC'])]);
    }
}
