<?php

namespace App\Controller\Resilience_rh;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AboutUsController extends AbstractController
{
    /**
     * @Route("/a-propos", name="app_about_us")
     */
    public function index()
    {
        return $this->render('about_us/index.html.twig', []);
    }
}
