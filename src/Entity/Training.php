<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Timestampable;
use App\Repository\TrainingRepository;
use Symfony\Component\HttpFoundation\File\File;
// Link the upload mapping to Training entity
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
// Validates that a particular field (or fields) in a Doctrine entity is (are) unique
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=TrainingRepository::class)
 * @ORM\Table(name="trainings")
 * @Vich\Uploadable
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity("title")
 */
class Training
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
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 3,
     *      minMessage = "Le titre de la formation doit comporter au moins {{ limit }} caractères",
     *      allowEmptyString = false
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="boolean", options={"default": true})
     */
    private $humanResources;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 10,
     *      minMessage = "Le texte doit comporter au moins {{ limit }} caractères",
     *      allowEmptyString = false
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 10,
     *      minMessage = "Le texte doit comporter au moins {{ limit }} caractères",
     *      allowEmptyString = false
     * )
     */
    private $public;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 10,
     *      minMessage = "Le texte doit comporter au moins {{ limit }} caractères",
     *      allowEmptyString = false
     * )
     */
    private $pedagogie;

    /**
     * @ORM\Column(type="text", options={"default": "Aucun."})
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 5,
     *      minMessage = "Le texte doit comporter au moins {{ limit }} caractères",
     *      allowEmptyString = false
     * )
     */
    private $prerequis;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 10,
     *      minMessage = "Le texte doit comporter au moins {{ limit }} caractères",
     *      allowEmptyString = false
     * )
     */
    private $evaluation;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 10,
     *      minMessage = "Le texte doit comporter au moins {{ limit }} caractères",
     *      allowEmptyString = false
     * )
     */
    private $lieu;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 10,
     *      minMessage = "Le texte doit comporter au moins {{ limit }} caractères",
     *      allowEmptyString = false
     * )
     */
    private $duree;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 3,
     *      minMessage = "La langue de la formation doit comporter au moins {{ limit }} caractères",
     *      allowEmptyString = false
     * )
     */
    private $langue;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 10,
     *      minMessage = "Le texte doit comporter au moins {{ limit }} caractères",
     *      allowEmptyString = false
     * )
     */
    private $intervenant;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 10,
     *      minMessage = "Le texte doit comporter au moins {{ limit }} caractères",
     *      allowEmptyString = false
     * )
     */
    private $contact;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="formation_pdf", fileNameProperty="pdfFilename")
     * @Assert\Image(
     *      maxSize="1M",
     * )
     * @var File|null
     */
    private $pdfFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pdfFilename;

    #endregion

    /*-------------------------------------------------------------
     *                      Constructor
     -------------------------------------------------------------*/

    public function __construct()
    {
        $this->humanResources = true;
        $this->prerequis = "Aucun.";
        $this->lieu = "À définir avec le client (idéalement en résidentiel).";
        $this->langue = "Française.";
        $this->intervenant = "<div>
                            David SAUVAGEOT<br>
                            (Psychologue du travail)<br>
                            ou un intervenant RESILIENCE-RH
                            </div>";
        $this->contact = "<div>
                            <strong>RESILIENCE-RH</strong><br>
                            David SAUVAGEOT<br>
                            6, place au bois<br>
                            57100 Thionville<br>
                            (+33) 3 82 56 62 67
                            </div>";
    }

    /*-------------------------------------------------------------
     *                    Getters - Setters
     -------------------------------------------------------------*/

    #region

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): string
    {
        return (new Slugify())->slugify($this->title);
    }

    public function getHumanResources(): ?bool
    {
        return $this->humanResources;
    }

    public function setHumanResources(bool $humanResources): self
    {
        $this->humanResources = $humanResources;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPublic(): ?string
    {
        return $this->public;
    }

    public function setPublic(string $public): self
    {
        $this->public = $public;

        return $this;
    }

    public function getPedagogie(): ?string
    {
        return $this->pedagogie;
    }

    public function setPedagogie(string $pedagogie): self
    {
        $this->pedagogie = $pedagogie;

        return $this;
    }

    public function getPrerequis(): ?string
    {
        return $this->prerequis;
    }

    public function setPrerequis(string $prerequis): self
    {
        $this->prerequis = $prerequis;

        return $this;
    }

    public function getEvaluation(): ?string
    {
        return $this->evaluation;
    }

    public function setEvaluation(string $evaluation): self
    {
        $this->evaluation = $evaluation;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(string $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    public function getIntervenant(): ?string
    {
        return $this->intervenant;
    }

    public function setIntervenant(string $intervenant): self
    {
        $this->intervenant = $intervenant;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $pdfFile
     */
    public function setPdfFile(?File $pdfFile = null): void
    {
        $this->pdfFile = $pdfFile;

        if (null !== $pdfFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->setUpdatedAt(new \DateTimeImmutable);
        }
    }

    public function getPdfFile(): ?File
    {
        return $this->pdfFile;
    }

    public function getPdfFilename(): ?string
    {
        return $this->pdfFilename;
    }

    public function setPdfFilename(?string $pdfFilename): self
    {
        $this->pdfFilename = $pdfFilename;

        return $this;
    }
    #endregion
}
