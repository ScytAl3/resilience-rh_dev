<?php

namespace App\Controller\Solutions;

use App\Entity\Candidature;
use App\Form\CandidatureType;
use App\Service\Candidature\CandidatureService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class JobOfferController extends AbstractController
{
    /**
     * @Route("/offre-emploi", name="app_job_offer")
     */
    public function index(Request $request, CandidatureService $candidatureService)
    {
        // On instancie un nouveau Contact
        $candidature = new Candidature();
        // On récupère le builder du formulaire associé à l'entité contact
        $candidatureForm = $this->createForm(CandidatureType::class, $candidature);
        $candidatureForm->handleRequest($request);
        // Appelle du service pour construire le mail de candidature spontanée
        $sendMail = $candidatureService->buildMail($candidature, $candidatureForm);
        if ($sendMail) {
            return $this->redirectToRoute('app_job_offer');
        }

        return $this->render('job_offer/index.html.twig', [
            'candidatureForm' => $candidatureForm->createView()
        ]);
    }
}
