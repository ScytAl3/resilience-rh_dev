<?php

namespace App\Controller\Resilience_rh;

use App\Repository\SolutionRepository;
use App\Repository\TestimonialRepository;
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
        // Initialisation d'un tableau vide
        $list = array();
        // Recupère un tableau de tableaux associatifs [id => value] :
        // la liste des identifiants des solutions proposées
        $solution_ids = $sRepo->getId();
        // Boucle pour récupérer la valeur des identifiants
        foreach ($solution_ids as $solution_id) {
            foreach ($solution_id as $key => $value) {
                array_push($list, $value);
            }
        }
        // dd($list);

        // Vérifie que l'identifiant passer dans l'url existe bien
        if (in_array($request->get('id'), $list)) {
            // Si identifiant existe retourne la liste des témoignages à cet identifiant de solution
            $testimonies = $tRepo->findBy(['solution' => $request->get('id')]);  
            // Recupération du nom de la solution (bouton) pour mettre à jour dynamiquement
            // le titre des témoignages affichés   
            $title = $sRepo->find($request->get('id'))->getLabel();   
        } else {
            // Sinon retourne la liste complète des témoignages            
            $testimonies = $tRepo->findAll();
            // Titre par défaut des témoignages
            $title = 'Tous les témoignages';
        }

        return $this->render('testimonies/index.html.twig', [
            'solutions' => $sRepo->findAll(),
            'testimonies' => $testimonies,
            'title' => $title,
        ]);
    }
}
