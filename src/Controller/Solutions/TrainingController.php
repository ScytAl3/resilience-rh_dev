<?php

namespace App\Controller\Solutions;

use App\Entity\Training;
use App\Service\Formation\PdfService;
use App\Repository\TrainingRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
                'titre' => 'Nos formation Ressources Humaines'
            ]);
        }

        if ($categorie == 'other') {
            return $this->render('training/training_category.html.twig', [
                'trainings' => $repo->findBy(['humanResources' => false], ['createdAt' => 'DESC']),
                'titre' => 'Nos autres formations',
            ]);
        }
    }

    /**
     * @Route("/formations/{id<[0-9]+>}/pdf", name="app_training_pdf", methods={"GET"})
     */
    public function generatePdf(Training $training, PdfService $pdfService)
    {
        $pdfService->getTrainingPdf($training);
        exit;
    }
}
