<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Timestampable;
use App\Repository\TestimonialRepository;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TestimonialRepository::class)
 * @ORM\Table(name="testimonials")
 * @ORM\HasLifecycleCallbacks()
 */
class Testimonial
{
    use Timestampable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=4)
     * @Assert\NotBlank
     * * @Assert\Regex(
     *      "/[A-Z][.][A-Z][.]/",
     *      message="Uniquement les initiales ex : X.Y."
     * )
     */
    private $initials;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Length(
     *      min = 3,
     *      minMessage = "The job must be at least {{ limit }} characters long"
     * )
     */
    private $job;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 10,
     *      max = 2000,
     *      minMessage = "Le témoignage doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "Le témoignage ne peut être plus long que {{ limit }} caractères",
     *      allowEmptyString = false
     * )
     */
    private $testimony;

    /**
     * @ORM\ManyToOne(targetEntity=Solution::class, inversedBy="testimonials")
     * @ORM\JoinColumn(name="solution_id", referencedColumnName="id", nullable=false)
     */
    private $solution;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInitials(): ?string
    {
        return $this->initials;
    }

    public function setInitials(string $initials): self
    {
        $this->initials = $initials;

        return $this;
    }

    public function getJob(): ?string
    {
        return $this->job;
    }

    public function setJob(?string $job): self
    {
        $this->job = $job;

        return $this;
    }

    public function getTestimony(): ?string
    {
        return $this->testimony;
    }

    public function setTestimony(string $testimony): self
    {
        $this->testimony = $testimony;

        return $this;
    }

    public function getSolution(): ?Solution
    {
        return $this->solution;
    }

    public function setSolution(?Solution $solution): self
    {
        $this->solution = $solution;

        return $this;
    }
}
