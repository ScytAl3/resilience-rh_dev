<?php

namespace App\Controller\Resilience_rh;

use App\Repository\SolutionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TestimoniesController extends AbstractController
{
    /**
     * @Route("/temoignages", name="app_testimonies")
     */
    public function index(SolutionRepository $repo)
    {
        return $this->render('testimonies/index.html.twig', [
            'solutions' => $repo->findAll(),
        ]);
    }
}
