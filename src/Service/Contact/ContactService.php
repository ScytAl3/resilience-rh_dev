<?php

namespace App\Service\Contact;

use App\Entity\Contact;
use Symfony\Component\Form\Form;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

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
     * @var FlashBagInterface
     */
    protected $flashBag;

    /**
     * Ajout des dépendances à la méthode __construct
     * @param MailerInterface $mailer 
     * @param mixed $uploadDirectory 
     * @return void 
     */
    public function __construct(MailerInterface $mailer, string $uploadDirectory, FlashBagInterface $flashBag)
    {
        $this->mailer = $mailer;
        $this->uploadDirectory = $uploadDirectory;
        $this->flashBag = $flashBag;
    }

    public function buildMail(Contact $contact, Form $contactForm)
    {
        // Booléen
        $isValid = false;
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
                // Recupère l'extension du fichier
                $fileExtension = $uploadedFile->guessExtension();
                // Concaténation du nom de fichier avec un id unique
                $newFilename = $originalFilename . '-' . uniqid() . '.' . $uploadedFile->guessExtension();
                // Deplace le fichier uploadé dans le dossier contact
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
            return $isValid;
        }
    }
}
