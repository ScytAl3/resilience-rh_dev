<?php

namespace App\Controller\Resilience_rh;

use App\Repository\SolutionRepository;
use App\Repository\TestimonialRepository;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class TestimoniesController extends AbstractController
{
    /**
     * @Route("/temoignages/{id<[0-9]+>?}", name="app_testimonies", methods={"GET"})
     */
    public function index(SolutionRepository $sRepo, TestimonialRepository $tRepo, Request $request)
    {
        // Tableau pour récupérer tous les témoignages
        $testimonies = [];
        // Tableau multidimensionnel pour récupérer les informations des témoignages associés aux solutions
        // [id-1 => [label-1, témoignages[]], ..., id-n => [label-n, témoignages[]]]
        $testimoniesBySolution = [];

        // Récupère la liste des témoignages
        $testimonies = $tRepo->getAllTestimonies();

        // dd($testimonies);

        // Pour chaque témoignage
        foreach ($testimonies as $testimonie) {
            // Si l'identifiant de la solution (key) n'est pas dans le tableau des témoignages par solution
            if (!array_key_exists($testimonie->getSolution()->getId(), $testimoniesBySolution)) {
                // Initialise un tableau multidimensionnel key => [label => nom, témoignages => []]
                $testimoniesBySolution[$testimonie->getSolution()->getId()] = [
                    'label' => $testimonie->getSolution()->getLabel(),
                    'testimonies' => []
                ];
            }
            // Ajoute le témoignage aux témoignages associés à la solution
            array_push($testimoniesBySolution[$testimonie->getSolution()->getId()]['testimonies'], [
                "initials" => $testimonie->getInitials(),
                "job" => $testimonie->getJob(),
                "testimony" => $testimonie->getTestimony()
            ]);
        }

        // dd($testimoniesBySolution);

        return $this->render('testimonies/index.html.twig', [
            'solutions' => $sRepo->findAll(),
            'testimoniesBySolution' => $testimoniesBySolution,
        ]);
    }
}
