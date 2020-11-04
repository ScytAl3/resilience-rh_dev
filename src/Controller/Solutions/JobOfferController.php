<?php

namespace App\Controller\Solutions;

use App\Entity\Candidature;
use App\Form\CandidatureType;
use App\Repository\JobOfferRepository;
use App\Service\Candidature\CandidatureService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class JobOfferController extends AbstractController
{
    /**
     * @Route("/offre-emploi", name="app_job_offer", methods={"GET", "POST"})
     */
    public function index(JobOfferRepository $repo, Request $request, CandidatureService $candidatureService)
    {
        // Récupère les offres d'emploi en cours
        $jobOffers = $repo->findBy(['isValid' => true], ['createdAt' => 'DESC']);
        // Instanciation d'un nouveau Contact
        $candidature = new Candidature();
        // Récupère le builder du formulaire associé à l'entité contact
        $candidatureForm = $this->createForm(CandidatureType::class, $candidature);
        $candidatureForm->handleRequest($request);

        if ($candidatureForm->isSubmitted() && $candidatureForm->isValid()) {
            // Récupère le contenu du champ fichier uploadé
            $attachedFile = $candidatureForm->get('uploadFile')->getData();
            // Récupère le nom du fichier uploadé
            $attachmentFilename = $candidatureService->uploadFile($attachedFile);

            // Création du mail de contact
            // Passage des parmètres au service pour la création du mail de contact
            $createMail = $candidatureService->buildMail(
                $candidature,
                $candidatureForm
            );
            // Ajout du fichier en pièce jointe
            $candidatureService->addAttachment($createMail, $attachmentFilename);

            // Envoi du mail
            $candidatureService->sendMail($createMail);

            // Suppression du CV uploadé
            $candidatureService->deleteUplodedFile($attachmentFilename);

            // Redirige vers la page des offre(s) d'emploi
            return $this->redirectToRoute('app_job_offer');
        }

        // Affiche le formulaire 
        return $this->render('job_offer/index.html.twig', [
            'jobOffers' => $jobOffers,
            'candidatureForm' => $candidatureForm->createView()
        ]);
    }
}
