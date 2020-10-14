<?php

namespace App\Controller;

use App\Repository\TestimonialRepository;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use UnexpectedValueException;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home", methods={"GET"})
     * @return Response 
     * @throws LogicException 
     * @throws UnexpectedValueException 
     */
    public function index(TestimonialRepository $repo): Response
    {
        // Récupération des 3 derniers témoignages
        $testimonies = $repo->findLastTestimonies();
        // dd($testimonies);

        return $this->render('home/index.html.twig', [
            'testimonies' => $testimonies,
        ]);
    }
}
