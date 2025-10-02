<?php

namespace App\Entity;

use App\Repository\SocietyRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SocietyRepository::class)]
class Society
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $contactedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $toRelaunchAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $relaunchedAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phoneNumber = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $about = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $recruit = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $answer = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $LinkedIn = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getContactedAt(): ?\DateTime
    {
        return $this->contactedAt;
    }

    public function setContactedAt(?\DateTime $contactedAt): static
    {
        $this->contactedAt = $contactedAt;

        return $this;
    }

    public function getToRelaunchAt(): ?\DateTime
    {
        return $this->toRelaunchAt;
    }

    public function setToRelaunchAt(?\DateTime $toRelaunchAt): static
    {
        $this->toRelaunchAt = $toRelaunchAt;

        return $this;
    }

    public function getRelaunchedAt(): ?\DateTime
    {
        return $this->relaunchedAt;
    }

    public function setRelaunchedAt(?\DateTime $relaunchedAt): static
    {
        $this->relaunchedAt = $relaunchedAt;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getAbout(): ?string
    {
        return $this->about;
    }

    public function setAbout(?string $about): static
    {
        $this->about = $about;

        return $this;
    }

    public function getRecruit(): ?string
    {
        return $this->recruit;
    }

    public function setRecruit(?string $recruit): static
    {
        $this->recruit = $recruit;

        return $this;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(?string $answer): static
    {
        $this->answer = $answer;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(?string $Email): static
    {
        $this->Email = $Email;

        return $this;
    }

    public function getLinkedIn(): ?string
    {
        return $this->LinkedIn;
    }

    public function setLinkedIn(?string $LinkedIn): static
    {
        $this->LinkedIn = $LinkedIn;

        return $this;
    }
}
