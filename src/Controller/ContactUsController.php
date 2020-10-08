<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Service\Contact\ContactService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;

class ContactUsController extends AbstractController
{
    /**
     * 
     * @var MailerInterface
     */
    protected $mailer;

    /**
     * 
     * @var mixed
     */
    protected $uploadDirectory;

    /**
     * Ajout des dépendances à la méthode __construct
     * @param MailerInterface $mailer 
     * @param mixed $uploadDirectory 
     * @return void 
     */
    public function __construct(MailerInterface $mailer, $uploadDirectory)
    {
        $this->mailer = $mailer;
        $this->uploadDirectory = $uploadDirectory;
    }

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

        // Si le formulaire est valide lors de l'envoi
        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            // dd($contactForm['uploadFile']->getData());

            // Appelle du service pour construire le mail
            $contactMail = $contactService->buildMail($contact);

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
                $contactMail->attachFromPath(
                    $destination . '/' . $newFilename,
                    $contact->getLastName() . '_' . $contact->getSubject() . '_' . $originalFilename . '.' . $fileExtension
                );
            }
            // Envoi du mail
            $this->mailer->send($contactMail);

            // Notification de l'envoie du mail
            $this->addFlash(
                'success',
                'Votre message à bien été envoyé'
            );
            // suppression du fichier uploadé
            $filesystem = new Filesystem();
            $filesystem->remove(
                $destination . '/' . $newFilename
            );
            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig', [
            'contactForm' => $contactForm->createView()
        ]);
    }
}
