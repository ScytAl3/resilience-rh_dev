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
        // On instancie un nouveau Contact
        $contact = new Contact();
        // On récupère le builder du formulaire associé à l'entité contact
        $contactForm = $this->createForm(ContactType::class, $contact);
        $contactForm->handleRequest($request);
        // Appelle du service pour construire le mail
        $contactMail = $contactService->buildMail($contact, $contactForm);
        // Si tout s'est bien déroulé
        if ($contactMail) {
            return $this->redirectToRoute('app_contact');
        }
        // Affiche le formulaire
        return $this->render('contact/index.html.twig', [
            'contactForm' => $contactForm->createView()
        ]);               
    }
}
