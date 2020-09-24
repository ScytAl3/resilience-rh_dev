<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Timestampable;
use App\Repository\ClientRepository;
// Validates that a particular field (or fields) in a Doctrine entity is (are) unique
use Symfony\Component\HttpFoundation\File\File;
// Link the upload mapping to Product entity
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 * @ORM\Table(name="clients")
 * @Vich\Uploadable
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity("title")
 */
class Client
{
    use Timestampable;

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
     *      max = 50,
     *      minMessage = "The name of the client must be at least {{ limit }} characters long",
     *      maxMessage = "The name of the client cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url(
     *      message = "The url '{{ value }}' is not a valid url",
     *      protocols = {"http", "https"}
     * )
     */
    private $url;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="client_image", fileNameProperty="imageName")
     * @Assert\Image(
     *      maxSize="1M",
     * )
     * 
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imageName;

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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->setUpdatedAt(new \DateTimeImmutable);
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }
}
