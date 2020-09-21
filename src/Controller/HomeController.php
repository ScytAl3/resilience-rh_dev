<?php

namespace App\Controller;

use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use UnexpectedValueException;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home", methods={"GET"})
     * @return Response 
     * @throws LogicException 
     * @throws UnexpectedValueException 
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', []);
    }
}
