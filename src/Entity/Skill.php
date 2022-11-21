<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Color;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SkillRepository::class)]
#[ORM\Table(name: '`skill`')]
class Skill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 2, max: 30)]
    private ?string $name = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    private ?int $percentage = null;

    #[ORM\Column(length: 2)]
    #[Assert\Length(min: 1, max: 2)]
    #[Assert\NotNull()]
    private ?string $place = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?color $colors = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    private ?bool $hidden = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToMany(targetEntity: Experience::class, mappedBy: 'skill')]
    private Collection $experiences;

    #[ORM\ManyToMany(targetEntity: Formation::class, mappedBy: 'skill')]
    private Collection $formations;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'skills')]
    private Collection $users;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
        $this->experiences = new ArrayCollection();
        $this->formations = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPercentage(): ?int
    {
        return $this->percentage;
    }

    public function setPercentage(int $percentage): self
    {
        $this->percentage = $percentage;

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(?string $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getColors(): ?color
    {
        return $this->colors;
    }

    public function setColors(?color $colors): self
    {
        $this->colors = $colors;

        return $this;
    }

    public function isHidden(): ?bool
    {
        return $this->hidden;
    }

    public function setHidden(bool $hidden): self
    {
        $this->hidden = $hidden;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Experiences>
     */
    public function getExperiences(): Collection
    {
        return $this->experiences;
    }

    public function addExperiences(Experience $experiences): self
    {
        if (!$this->experiences->contains($experiences)) {
            $this->experiences->add($experiences);
            $experiences->addSkill($this);
        }

        return $this;
    }

    public function removeExperiences(Experience $experiences): self
    {
        if ($this->experiences->removeElement($experiences)) {
            $experiences->removeSkill($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Formation>
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }

    public function addFormations(Formation $formations): self
    {
        if (!$this->formations->contains($formations)) {
            $this->formations->add($formations);
            $formations->addSkill($this);
        }

        return $this;
    }

    public function removeFormations(Formation $formations): self
    {
        if ($this->formations->removeElement($formations)) {
            $formations->removeSkill($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addSkill($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeSkill($this);
        }

        return $this;
    }
}
