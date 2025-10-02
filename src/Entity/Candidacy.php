<?php

namespace App\Entity;

use App\Repository\CandidacyRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CandidacyRepository::class)]
class Candidacy
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $job = null;

    #[ORM\Column(length: 255)]
    private ?string $link = null;

    #[ORM\Column(length: 255)]
    private ?string $society = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $about = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $answer = null;

    #[ORM\Column]
    private ?\DateTime $appliedAt = null;

    #[ORM\Column]
    private ?\DateTime $toRelaunchAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $relaunchedAt = null;

    #[ORM\Column(length: 255)]
    private ?string $location = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJob(): ?string
    {
        return $this->job;
    }

    public function setJob(string $job): static
    {
        $this->job = $job;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): static
    {
        $this->link = $link;

        return $this;
    }

    public function getSociety(): ?string
    {
        return $this->society;
    }

    public function setSociety(string $society): static
    {
        $this->society = $society;

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

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(?string $answer): static
    {
        $this->answer = $answer;

        return $this;
    }

    public function getAppliedAt(): ?\DateTime
    {
        return $this->appliedAt;
    }

    public function setAppliedAt(\DateTime $appliedAt): static
    {
        $this->appliedAt = $appliedAt;

        return $this;
    }

    public function getToRelaunchAt(): ?\DateTime
    {
        return $this->toRelaunchAt;
    }

    public function setToRelaunchAt(\DateTime $toRelaunchAt): static
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

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }
}
