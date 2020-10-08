<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    /**
     * @var string|null
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 3,
     *      max = 100,
     *      minMessage = "Le prénom doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "Le prénom ne peut être plus long que {{ limit }} caractères",
     *      allowEmptyString = false
     * )
     */
    private $firstName;

    /**
     * @var string|null
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 3,
     *      max = 100,
     *      minMessage = "Le nom doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "Le nom ne peut être plus long que {{ limit }} caractères",
     *      allowEmptyString = false
     * )
     */
    private $lastName;

    /**
     * @var string|null
     * @Assert\NotBlank
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string|null
     * @Assert\NotBlank
     * @Assert\Regex(
     *      pattern = "/^(?:0|\(?\+33\)?\s?|0033\s?)[1-79](?:[\.\-\s]?\d\d){4}$/",
     *      htmlPattern= "^(?:0|\(?\+33\)?\s?|0033\s?)[1-79](?:[\.\-\s]?\d\d){4}$",
     *      message = "International phone number e.g. : +33610254585."
     * )
     */
    private $phone;

    /**
     * @var string|null
     * @Assert\Choice({
     *      "Formation",
     *      "Recrutement",
     *      "Bilan de compétences",
     *      "Orientation",
     *      "Carrière/CV",
     *      "Déposer votre candidature",
     *      "Autre"
     * },
     *      message = "Veuillez choisir le sujet",
     * )
     */
    private $subject;

    /**
     * @var string|null
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 10,
     *      max = 2000,
     *      minMessage = "Le message doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "Le message ne peut être plus long que {{ limit }} caractères",
     *      allowEmptyString = false
     * )
     */
    private $message;

    /**
     * Get min = 3,
     *
     * @return  string|null
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set min = 3,
     *
     * @param  string|null  $firstName  min = 3,
     *
     * @return  self
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get min = 3,
     *
     * @return  string|null
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set min = 3,
     *
     * @param  string|null  $lastName  min = 3,
     *
     * @return  self
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get the value of email
     *
     * @return  string|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @param  string  $email
     *
     * @return  self
     */
    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get pattern = "/^(?:0|\(?\+33\)?\s?|0033\s?)[1-79](?:[\.\-\s]?\d\d){4}$/",
     *
     * @return  string|null
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set pattern = "/^(?:0|\(?\+33\)?\s?|0033\s?)[1-79](?:[\.\-\s]?\d\d){4}$/",
     *
     * @param  string  $phone  pattern = "/^(?:0|\(?\+33\)?\s?|0033\s?)[1-79](?:[\.\-\s]?\d\d){4}$/",
     *
     * @return  self
     */
    public function setPhone(string $phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get "Formation",
     *
     * @return  string|null
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set "Formation",
     *
     * @param  string|null  $subject  "Formation",
     *
     * @return  self
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get the value of message
     *
     * @return  string|null
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set the value of message
     *
     * @param  string  $message
     *
     * @return  self
     */
    public function setMessage(string $message)
    {
        $this->message = $message;

        return $this;
    }
}
