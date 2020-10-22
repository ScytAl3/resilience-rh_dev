<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Candidature
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
