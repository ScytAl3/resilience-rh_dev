<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Mime\Address;

class ContactUsController extends AbstractController
{
    /**
     * 
     * @var MailerInterface
     */
    protected $mailer;

    protected $uploadDirectory;

    /**
     * Ajout des dépendances à la méthode __construct
     * @param MailerInterface $mailer 
     * @return void 
     */
    public function __construct(MailerInterface $mailer, $uploadDirectory)
    {
        $this->mailer = $mailer;
        $this->uploadDirectory = $uploadDirectory;
    }

    /**
     * @Route("/contact", name="app_contact")
     */
    public function index(Request $request)
    {
        // On instancie un nouveau Contact
        $contact = new Contact();
        // On récupère le builder du formulaire associé à l'entité contact
        $contactForm = $this->createForm(ContactType::class, $contact);
        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            // dd($contactForm['uploadFile']->getData());

            // Création du mail de contact
            $email = (new TemplatedEmail())
                ->from($contact->getEmail())
                ->to(new Address('david.sauvageot@resilience-rh.com', 'Résilience-RH'))
                ->subject($contact->getSubject())
                ->htmlTemplate('contact/contact_email.html.twig')
                // Pass variables to the template
                ->context([
                    'firstname' => $contact->getFirstName(),
                    'lastname' => $contact->getLastName(),
                    'phone' => $contact->getPhone(),
                    'mail' => $contact->getEmail(),
                    'subject' => $contact->getSubject(),
                    'message' => $contact->getMessage()
                ]);

            // Si un fichier a été uploadé
            if (!is_null($contactForm['uploadFile']->getData())) {
                // Recupère le fichier
                $uploadedFile = $contactForm['uploadFile']->getData();
                // Recupère le chemin vers le dossier de sauvegarde des uploads : set in config/services.yaml
                $destination = $this->uploadDirectory;
                // Recupère le nom du fichier
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                // Recupère l'extension du fichier
                $fileExtension = $uploadedFile->guessExtension();
                // Concaténation du nom de fichier avec un id unique
                $newFilename = $originalFilename . '-' . uniqid() . '.' . $uploadedFile->guessExtension();
                // Deplace le fichier uploadé dans le dossier contact
                $uploadedFile->move(
                    $destination,
                    $newFilename
                );
                // Ajout du fichier uploadé avec 
                $email->attachFromPath(
                    $destination . '/' . $newFilename,
                    $contact->getLastName() . '_' . $contact->getSubject() . '_' . $originalFilename . '.' . $fileExtension
                );
            }
            // Envoi du mail
            $this->mailer->send($email);
            // $contactNotification->notify($contact);
            $this->addFlash(
                'success',
                'Votre message à bien été envoyé'
            );
            // suppression du fichier uploadé
            $filesystem = new Filesystem();
            $filesystem->remove(
                $destination,
                $newFilename
            );
            
            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig', [
            'contactForm' => $contactForm->createView()
        ]);
    }
}
