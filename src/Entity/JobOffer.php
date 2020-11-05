<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Timestampable;
use App\Repository\JobOfferRepository;
use Symfony\Component\Validator\Constraints as Assert;
// Validates that a particular field (or fields) in a Doctrine entity is (are) unique
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=JobOfferRepository::class)
 * @ORM\Table(name="jobOffers")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity("title")
 */
class JobOffer
{
    use Timestampable;

    /*-------------------------------------------------------------
     *                      Properties
     -------------------------------------------------------------*/

    #region

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 10,
     *      minMessage = "Le texte doit comporter au moins {{ limit }} caractères",
     *      allowEmptyString = false
     * )
     */
    private $introduction;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 3,
     *      minMessage = "Le titre de l'offre doit comporter au moins {{ limit }} caractères",
     *      allowEmptyString = false
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 3,
     *      minMessage = "Le contrat de l'offre doit comporter au moins {{ limit }} caractères",
     *      allowEmptyString = false
     * )
     */
    private $contract;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 10,
     *      minMessage = "Le texte doit comporter au moins {{ limit }} caractères",
     *      allowEmptyString = false
     * )
     */
    private $presentation;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 10,
     *      minMessage = "Le texte doit comporter au moins {{ limit }} caractères",
     *      allowEmptyString = false
     * )
     */
    private $mission;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 10,
     *      minMessage = "Le texte doit comporter au moins {{ limit }} caractères",
     *      allowEmptyString = false
     * )
     */
    private $profile;

    /**
     * @ORM\Column(type="boolean", options={"default": true})
     */
    private $isValid;

    /**
     * @ORM\Column(type="string", length=255, options={"default": "CDI"})
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 3,
     *      minMessage = "Le type de contrat doit comporter au moins {{ limit }} caractères",
     *      allowEmptyString = false
     * )
     */
    private $contractType;

    /**
     * @ORM\Column(type="string", length=255, options={"default": "Région lorraine"})
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 3,
     *      minMessage = "Le lieu de l'offre doit comporter au moins {{ limit }} caractères",
     *      allowEmptyString = false
     * )
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=255, options={"default": "fixe + primes"})
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 3,
     *      minMessage = "La rémunération doit comporter au moins {{ limit }} caractères",
     *      allowEmptyString = false
     * )
     */
    private $remuneration;

    /**
     * @ORM\Column(type="string", length=255, options={"default": "au plus tôt"})
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 3,
     *      minMessage = "La date de prise de fonction doit comporter au moins {{ limit }} caractères",
     *      allowEmptyString = false
     * )
     */
    private $startDate;

    #endregion

    /*-------------------------------------------------------------
     *                      Constructor
     -------------------------------------------------------------*/

    public function __construct()
    {
        $this->isValid = true;
    }

    /*-------------------------------------------------------------
     *                    Getters - Setters
     -------------------------------------------------------------*/

    #region

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    public function setIntroduction(string $introduction): self
    {
        $this->introduction = $introduction;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): string
    {
        return (new Slugify())->slugify($this->title);
    }

    public function getContract(): ?string
    {
        return $this->contract;
    }

    public function setContract(string $contract): self
    {
        $this->contract = $contract;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getMission(): ?string
    {
        return $this->mission;
    }

    public function setMission(string $mission): self
    {
        $this->mission = $mission;

        return $this;
    }

    public function getProfile(): ?string
    {
        return $this->profile;
    }

    public function setProfile(string $profile): self
    {
        $this->profile = $profile;

        return $this;
    }

    public function getIsValid(): ?bool
    {
        return $this->isValid;
    }

    public function setIsValid(bool $isValid): self
    {
        $this->isValid = $isValid;

        return $this;
    }

    public function getContractType(): ?string
    {
        return $this->contractType;
    }

    public function setContractType(string $contractType): self
    {
        $this->contractType = $contractType;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getRemuneration(): ?string
    {
        return $this->remuneration;
    }

    public function setRemuneration(string $remuneration): self
    {
        $this->remuneration = $remuneration;

        return $this;
    }

    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    public function setStartDate(string $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    #endregion
}
