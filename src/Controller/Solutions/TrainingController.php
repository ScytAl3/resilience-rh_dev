<?php

namespace App\Controller\Solutions;

use App\Repository\TrainingRepository;
use App\Service\Formation\PdfService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TrainingController extends AbstractController
{
    /**
     * @Route("/formations", name="app_training")
     */
    public function index(TrainingRepository $repo)
    {
        return $this->render('training/index.html.twig', ['trainings' => $repo->findBy([], ['createdAt' => 'DESC'])]);
    }

    /**
     * @Route("/formations/pdf", name="app_training_pdf", methods={"GET"})
     */
    public function generatePdf(PdfService $pdfService)
    {
        $pdfService->getTrainingPdf();
        exit;
    }
}
