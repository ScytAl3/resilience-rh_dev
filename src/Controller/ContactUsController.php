<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Service\Contact\ContactService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactUsController extends AbstractController
{
    /**
     * @Route("/contact", name="app_contact", methods={"GET", "POST"})
     */
    public function index(Request $request, ContactService $contactService)
    {
        // Booléen pour savoir si un fichier a été uploadé
        $downloaded = false;
        // Instanciation d'un nouveau Contact
        $contact = new Contact();
        // Récupère le builder du formulaire associé à l'entité contact
        $contactForm = $this->createForm(ContactType::class, $contact);
        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            // Création du mail de contact
            // Passage des parmètres au service pour la création du mail de contact
            $createMail = $contactService->buildMail(
                $contact,
                $contactForm
            );

            // Récupère le contenu du champ du fichier à uploader
            $attachedFile = $contactForm->get('uploadFile')->getData();

            // Cette condition est nécessaire car le champ "uploadFile" n'est pas obligatoire
            // le fichier PDF ne doit donc être traité que lorsqu'un fichier est téléchargé
            if ($attachedFile) {
                // Récupère le nom du fichier
                $attachmentFilename = $contactService->uploadFile($attachedFile);
                // Ajout du fichier en pièce jointe
                $contactService->addAttachment($createMail, $attachmentFilename);
                // Passe le booléen pour savoir si un fichier a été téléchargé à TRUE
                $downloaded = true;
            }
            // Envoi du mail
            $contactService->sendMail($createMail);

            // Si un fichier a été uploadé le supprime
            if ($downloaded) {
                $contactService->deleteUplodedFile($attachmentFilename);             
            }

            // Redirige vers la page contact 
            return $this->redirectToRoute('app_contact');
        }

        // Affiche le formulaire
        return $this->render('contact/index.html.twig', [
            'contactForm' => $contactForm->createView()
        ]);
    }
}
