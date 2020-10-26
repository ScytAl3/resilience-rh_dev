<?php

namespace App\Service\Contact;

use App\Entity\Contact;
use Symfony\Component\Form\Form;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class ContactService
{
    /**
     * @var MailerInterface
     */
    protected $mailer;

    /**
     * @var string
     */
    protected $uploadDirectory;

    /**
     * @var SluggerInterface
     */
    private $slugger;

    /**
     * @var FlashBagInterface
     */
    protected $flashBag;

    /**
     * Ajout des dépendances à la méthode __construct
     * @param MailerInterface $mailer 
     * @param mixed $uploadDirectory 
     * @return void 
     */
    public function __construct(MailerInterface $mailer, string $uploadDirectory, SluggerInterface $slugger, FlashBagInterface $flashBag)
    {
        $this->mailer = $mailer;
        $this->uploadDirectory = $uploadDirectory;
        $this->slugger = $slugger;
        $this->flashBag = $flashBag;
    }

    public function buildMail(Contact $contact, Form $contactForm): bool
    {
        // Booléens
        $isValid = false;
        $uploaded = false;
        // Si le formulaire est valide lors de l'envoi
        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            // dd($contactForm['uploadFile']->getData());

            // Création du mail de contact
            $contactMail = (new TemplatedEmail())
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
                // Transforme le nom du fichier avec des tirets
                $safeFilename = $this->slugger->slug($originalFilename);
                // Recupère l'extension du fichier
                $fileExtension = $uploadedFile->guessExtension();
                // Concaténation du nom de fichier avec un id unique
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $fileExtension;
                // Deplace le fichier uploadé dans le dossier contact
                try {
                    $uploadedFile->move(
                        $destination,
                        $newFilename
                    );
                    // Ajout du fichier uploadé 
                    $contactMail->attachFromPath(
                        $destination . '/' . $newFilename,
                        $contact->getLastName() . '_' . $contact->getSubject() . '_' . $originalFilename . '.' . $fileExtension
                    );

                    $uploaded = true;

                } catch (FileException $e) {
                    // Notification de l'erreur
                    $this->flashBag->add(
                        'danger',
                        'Il y a eu un problème avec le fichier téléchargé ' . $e
                    );
                }
            }
            // Envoi du mail
            $this->mailer->send($contactMail);

            // Notification de l'envoie du mail
            $this->flashBag->add(
                'success',
                'Votre message à bien été envoyé'
            );
            // Suppression si fichier uploadé
            if ($uploaded) {
                $filesystem = new Filesystem();
                $filesystem->remove(
                    $destination . '/' . $newFilename
                );
            }
            // Passe le booléen à TRUE
            $isValid = true;            
        }
        return $isValid;
    }
}
