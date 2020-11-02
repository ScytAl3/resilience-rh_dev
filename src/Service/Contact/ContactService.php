<?php

namespace App\Service\Contact;

use App\Entity\Contact;
use LogicException;
use InvalidArgumentException;
use Symfony\Component\Form\Form;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Exception\InvalidArgumentException as ExceptionInvalidArgumentException;
use Symfony\Component\Mime\Exception\LogicException as ExceptionLogicException;
use Symfony\Component\String\Slugger\SluggerInterface;
use Throwable;

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

    /**
     * Enregistre un fichier uploadé dans le dossier configuré et renvoie le nom du fichier
     * @param UploadedFile $file 
     * @return string 
     * @throws LogicException 
     * @throws InvalidArgumentException 
     * @throws ExceptionLogicException 
     */
    public function uploadFile(UploadedFile $file): String
    {
        // Recupère le nom du fichier uploadé 
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        // Crée un slug compatible avec l'URL à partir du nom du fichier uploadé
        $safeFilename = $this->slugger->slug($originalFilename);
        // Concaténation du nom avec un id unique et l'extension du fichier
        $fileName = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();
        // Deplace le fichier uploadé dans le dossier contact
        try {
            $file->move(
                $this->getTargetDirectory(),
                $fileName
            );
        } catch (FileException $e) {
            // Notification de l'erreur
            $this->flashBag->add(
                'danger',
                'Il y a eu un problème avec le fichier téléchargé ' . $e
            );
        }
        // Retourne le nom du fichier uploadé
        return $fileName;
    }

    /**
     * Contruit le modèle du mail a envoyer
     * @param Contact $contact 
     * @param Form $contactForm 
     * @return TemplatedEmail 
     * @throws ExceptionInvalidArgumentException 
     * @throws ExceptionLogicException 
     */
    public function buildMail(Contact $contact, Form $contactForm): TemplatedEmail
    {
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
        // Retourne le mail construit
        return $contactMail;
    }

    /**
     * Ajoute une pièce jointe à un mail
     * @param TemplatedEmail $email 
     * @param string $attachmentFilename 
     * @return void 
     */
    public function addAttachment(TemplatedEmail $email, string $attachmentFilename)
    {
        $email->attachFromPath(
            $this->getTargetDirectory() . '/' . $attachmentFilename,
        );
    }

    /**
     * Envoie un mail
     * @param TemplatedEmail $email 
     * @return void 
     * @throws TransportExceptionInterface 
     */
    public function sendMail(TemplatedEmail $email)
    {
        // Envoi du mail
        $this->mailer->send($email);

        // Notification de l'envoie du mail
        $this->flashBag->add(
            'success',
            'Votre message à bien été envoyé'
        );
    }

    /**
     * Supprime un fichier
     * @param string $filename 
     * @return void 
     * @throws Throwable 
     * @throws IOException 
     */
    public function deleteUplodedFile(string $filename)
    {
        // Suppression si fichier uploadé
        $filesystem = new Filesystem();
        $filesystem->remove(
            $this->getTargetDirectory() . '/' . $filename
        );
    }    

    public function getTargetDirectory()
    {
        return $this->uploadDirectory;
    }
}
