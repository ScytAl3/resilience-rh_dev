<?php

namespace App\Controller;

use App\Repository\PublicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PublicationController extends AbstractController
{
    /**
     * @Route("/publications", name="app_publication")
     */
    public function index(PublicationRepository $repo)
    {
        return $this->render('publication/index.html.twig', ['publications' => $repo->findBy([], ['createdAt' => 'DESC'])]);
    }
}
