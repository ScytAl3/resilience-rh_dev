<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class OurPartnersController extends AbstractController
{
    /**
     * @Route("/nos-partenaires", name="app_our_partners")
     */
    public function index()
    {
        return $this->render('our_partners/index.html.twig', [
            'controller_name' => 'OurPartnersController',
        ]);
    }
}
