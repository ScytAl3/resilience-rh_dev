<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class OrientationController extends AbstractController
{
    /**
     * @Route("/orientation", name="app_orientation")
     */
    public function index()
    {
        return $this->render('orientation/index.html.twig', []);
    }
}
