<?php

namespace App\Controller\Solutions;

use App\Entity\Training;
use App\Service\Formation\PdfService;
use App\Repository\TrainingRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class TrainingController extends AbstractController
{
    /**
     * @Route("/formations", name="app_training", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('training/index.html.twig', []);
    }

    /**
     * @Route("/formations/{categorie<rh|other>}", name="app_training_category", methods={"GET"})
     */
    public function showTrainingCategory(string $categorie, TrainingRepository $repo)
    {
        if ($categorie == 'rh') {
            return $this->render('training/training_category.html.twig', [
                'trainings' => $repo->findBy(['humanResources' => true], ['createdAt' => 'DESC']),
                'icon' => 'users',
                'titre' => 'Nos formation Ressources Humaines',
                'btn_label' => 'autres formations',
                'btn_path' =>'other'
            ]);
        }

        if ($categorie == 'other') {
            return $this->render('training/training_category.html.twig', [
                'trainings' => $repo->findBy(['humanResources' => false], ['createdAt' => 'DESC']),
                'icon' => 'chalkboard-teacher',
                'titre' => 'Nos autres formations',
                'btn_label' => 'formations rh',
                'btn_path' => 'rh'
            ]);
        }
    }

    /**
     * @Route("/formations/{id<[0-9]+>}/pdf", name="app_training_pdf", methods={"GET"})     *
     * @param Training $training
     * @param PdfService $pdfService
     * @return void
     */ 
    public function generatePdf(Training $training, PdfService $pdfService)
    {
        $pdfService->getTrainingPdf($training);
        exit;
    }
}
