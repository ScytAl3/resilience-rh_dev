<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SolutionRepository;
// Validates that a particular field (or fields) in a Doctrine entity is (are) unique
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=SolutionRepository::class)
 * @ORM\Table(name="solutions")
 * @UniqueEntity("label")
 */
class Solution
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 3,
     *      max = 100,
     *      minMessage = "The name of the solution must be at least {{ limit }} characters long",
     *      maxMessage = "The name of the solution cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false
     * )
     */
    private $label;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getSlug(): string
    {
        return (new Slugify())->slugify($this->label);
    }
}
