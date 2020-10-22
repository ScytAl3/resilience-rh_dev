<?php

namespace App\Service\Candidature;

use App\Entity\Candidature;
use Symfony\Component\Form\Form;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\Exception\LogicException;
use Symfony\Component\Form\Exception\OutOfBoundsException;
use Symfony\Component\Form\Exception\RuntimeException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Mime\Exception\InvalidArgumentException;
use Symfony\Component\Mime\Exception\LogicException as ExceptionLogicException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Throwable;

class CandidatureService
{
    /**
     * @var MailerInterface
     */
    protected $mailer;

    /**
     * @var mixed
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
    public function __construct(MailerInterface $mailer, $uploadDirectory, FlashBagInterface $flashBag)
    {
        $this->mailer = $mailer;
        $this->uploadDirectory = $uploadDirectory;
        $this->flashBag = $flashBag;
    }

    /**
     * 
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
    public function buildMail(Candidature $candidature, Form $candidatureForm): bool
    {
        // Booléen 
        $isValid = false;
        // Si le formulaire est valide lors de l'envoi
        if ($candidatureForm->isSubmitted() && $candidatureForm->isValid()) {
            // dd($candidatureForm);

            // Création du mail de candidature
            $email = (new TemplatedEmail())
                ->from($candidature->getEmail())
                ->to(new Address('david.sauvageot@resilience-rh.com', 'Résilience-RH'))
                ->subject('Candidature spontanée')
                ->htmlTemplate('job_offer/candidature_email.html.twig')
                // Pass variables to the template
                ->context([
                    'firstname' => $candidature->getFirstName(),
                    'lastname' => $candidature->getLastName(),
                    'mail' => $candidature->getEmail(),
                    'message' => $candidature->getMessage()
                ]);
            // Recupère le CV uploadé
            $uploadedFile = $candidatureForm['uploadFile']->getData();
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
            // Ajout du CV uploadé 
            $email->attachFromPath(
                $destination . '/' . $newFilename,
                $candidature->getLastName() . '_' . $originalFilename . '.' . $fileExtension
            );
            // Envoi du mail
            $this->mailer->send($email);

            // Notification de l'envoie du mail
            $this->flashBag->add(
                'success',
                'Votre candidature à bien été envoyé'
            );
            // Suppression du CV uploadé
            $filesystem = new Filesystem();
            $filesystem->remove(
                $destination . '/' . $newFilename
            );
            // Passe le booléen à TRUE
            $isValid = true;
        }
        return $isValid;
    }
}
