<?php

namespace App\Controller\Solutions;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SkillsAssessmentController extends AbstractController
{
    /**
     * @Route("/bilan-de-competence", name="app_skills_assessment")
     */
    public function index()
    {
        return $this->render('skills_assessment/index.html.twig', []);
    }
}
