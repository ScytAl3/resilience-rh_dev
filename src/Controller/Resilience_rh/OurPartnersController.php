<?php

namespace App\Controller\Resilience_rh;

use App\Repository\PartnerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class OurPartnersController extends AbstractController
{
    /**
     * @Route("/nos-partenaires", name="app_our_partners")
     */
    public function index(PartnerRepository $repo)
    {
        return $this->render('our_partners/index.html.twig', ['partners' => $repo->findBy([], ['createdAt' => 'DESC'])]);
    }
}
