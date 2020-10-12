<?php

namespace App\Entity;

use App\Repository\TestimonialRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TestimonialRepository::class)
 */
class Testimonial
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=4)
     */
    private $initials;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $job;

    /**
     * @ORM\Column(type="text")
     */
    private $testimony;

    /**
     * @ORM\ManyToOne(targetEntity=Solution::class, inversedBy="testimonials")
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
