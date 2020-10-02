<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class JobOfferController extends AbstractController
{
    /**
     * @Route("/offre-emploi", name="app_job_offer")
     */
    public function index()
    {
        return $this->render('job_offer/index.html.twig', []);
    }
}
