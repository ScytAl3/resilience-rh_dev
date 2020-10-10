<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LegalNoticeController extends AbstractController
{
    /**
     * @Route("/mentions-legales", name="app_legal_notice")
     */
    public function index()
    {
        return $this->render('legal_notice/index.html.twig', []);
    }
}
