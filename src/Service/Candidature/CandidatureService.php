<?php

namespace App\Service\Candidature;

use Throwable;
use App\Entity\Candidature;
use Symfony\Component\Form\Form;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Form\Exception\LogicException;
use Symfony\Component\Form\Exception\RuntimeException;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Form\Exception\OutOfBoundsException;
use Symfony\Component\Mime\Exception\InvalidArgumentException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Mime\Exception\LogicException as ExceptionLogicException;

class CandidatureService
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
                'Il y a eu un problème avec le CV téléchargé ' . $e
            );
        }
        // Retourne le nom du fichier uploadé
        return $fileName;
    }

    /**
     * Contruit le modèle du mail a envoyer
     * @param Candidature $candidature 
     * @param Form $candidatureForm 
     * @return bool 
     * @throws LogicException 
     * @throws InvalidArgumentException 
     * @throws ExceptionLogicException 
     * @throws OutOfBoundsException 
     * @throws RuntimeException 
     * @throws TransportExceptionInterface 
     * @throws Throwable 
     * @throws IOException 
     */
    public function buildMail(Candidature $candidature, Form $candidatureForm): TemplatedEmail
    {
        // Recupère le sujet : candidature spontanée ou offre
        $subject = ($candidatureForm['jobOffer']->getData() !== null)  ?
            $candidatureForm['jobOffer']->getData()->getTitle()
            :
            'Candidature spontanée';

        // Création du mail de candidature
        $email = (new TemplatedEmail())
            ->from($candidature->getEmail())
            ->to(new Address('david.sauvageot@resilience-rh.com', 'Résilience-RH'))
            ->subject($subject)
            ->htmlTemplate('job_offer/candidature_email.html.twig')
            // Pass variables to the template
            ->context([
                'title' => $subject,
                'firstname' => $candidature->getFirstName(),
                'lastname' => $candidature->getLastName(),
                'mail' => $candidature->getEmail(),
                'message' => $candidature->getMessage()
            ]);
        // Retourne le mail construit
        return $email;
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
