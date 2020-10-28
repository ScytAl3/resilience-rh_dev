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
     * @Route("/formations/{slug?}", name="app_training")
     */
    public function index(?string $slug, TrainingRepository $repo): Response
    {
        switch ($slug) {
            case 'rh':
                return $this->render('training/index.html.twig', [
                    'trainings' => $repo->findBy(['humanResources' => true], ['createdAt' => 'DESC']),
                    'titre' => 'Nos formation Ressources Humaines'
                    ]);
                break;

            case 'other':
                return $this->render('training/index.html.twig', [
                    'trainings' => $repo->findBy(['humanResources' => false], ['createdAt' => 'DESC']),
                    'titre' => 'Nos autres formations',
                    ]);
                break;

            default:
                return $this->render('training/index.html.twig', [
                    'trainings' => $repo->findBy([], ['createdAt' => 'DESC']),
                    'titre' => 'Toutes nos formations',
                    ]);
                break;
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
