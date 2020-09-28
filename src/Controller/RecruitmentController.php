<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RecruitmentController extends AbstractController
{
    /**
     * @Route("/recrutement", name="app_recruitment")
     */
    public function index()
    {
        return $this->render('recruitment/index.html.twig', []);
    }
}
