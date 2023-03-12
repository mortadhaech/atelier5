<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\ClassroomRepository;


#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    #[ORM\ManyToOne(targetEntity: Classroom::class, inversedBy: 'students')]
    private ?Classroom $classroom = null;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $NSC= null;

    #[ORM\Column(length: 255)]
    private ?string $Email = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    public ?\DateTimeInterface $creation_date = null;

    #[ORM\Column]
    private ?int $enabled = null;

    #[ORM\Column]
    private ?int $moyenne = null;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function getNSC(): ?int
    {
        return $this->NSC;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getClassroom(): ?Classroom
    {
        return $this->classroom;
    }

    public function setClassroom(?Classroom $classroom): self
    {
        $this->classroom = $classroom;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creation_date;
    }

    public function setCreationDate(\DateTimeInterface $creation_date): self
    {
        $this->creation_date = $creation_date;

        return $this;
    }

   
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

   

    public function setEnabled(int $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getMoyenne(): ?int
    {
        return $this->moyenne;
    }

    public function setMoyenne(int $moyenne): self
    {
        $this->moyenne = $moyenne;

        return $this;
    }


}
