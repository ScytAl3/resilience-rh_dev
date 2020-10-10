<?php

namespace App\Controller\Solutions;

use App\Repository\TrainingRepository;
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
}
