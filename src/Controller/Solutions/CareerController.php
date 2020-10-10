<?php

namespace App\Controller\Solutions;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CareerController extends AbstractController
{
    /**
     * @Route("/carriere", name="app_career")
     */
    public function index()
    {
        return $this->render('career/index.html.twig', []);
    }
}
