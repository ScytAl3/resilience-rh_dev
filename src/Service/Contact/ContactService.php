<?php

namespace App\Service\Contact;

use App\Entity\Contact;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class ContactService
{    
    public function buildMail(Contact $contact)
    {
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

        return $email;
    }
}
