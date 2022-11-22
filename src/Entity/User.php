<?php

namespace App\Entity;

use App\Entity\Skill;
use App\Entity\Project;
use App\Entity\Formation;
use App\Entity\Experience;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[UniqueEntity('email')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 2, max: 50)]
    private ?string $fullName = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\Email()]
    #[Assert\Length(min: 2, max: 180)]
    private ?string $email = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank()]
    private ?string $password = null;

    private $plain_password;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotNull()]
    private ?string $about = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    private ?bool $front = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    private ?bool $hidden = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToMany(targetEntity: skill::class, inversedBy: 'users')]
    private Collection $skills;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\isNull()]
    private ?string $filename = null;

    #[ORM\ManyToMany(targetEntity: formation::class, inversedBy: 'users')]
    private Collection $formations;

    #[ORM\ManyToMany(targetEntity: experience::class, inversedBy: 'users')]
    private Collection $experiences;

    #[ORM\ManyToMany(targetEntity: project::class, inversedBy: 'users')]
    private Collection $projects;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
        $this->skills = new ArrayCollection();
        $this->formations = new ArrayCollection();
        $this->experiences = new ArrayCollection();
        $this->projects = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getFullName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): string
    {
        return (string) $this->plain_password;
    }

    public function setPlainPassword(?string $plain_password): self
    {
        $this->plain_password = $plain_password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function setAbout(string $about): self
    {
        $this->about = $about;

        return $this;
    }

    public function isFront(): ?bool
    {
        return $this->front;
    }

    public function setFront(bool $front): self
    {
        $this->front = $front;

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
        $this->updatedAt = new \DateTimeImmutable();

        return $this;
    }

    public function getAbout(): ?string
    {
        return $this->about;
    }

    /**
     * @return Collection<int, skill>
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(skill $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills->add($skill);
        }

        return $this;
    }

    public function removeSkill(skill $skill): self
    {
        $this->skills->removeElement($skill);

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * @return Collection<int, formation>
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }

    public function addFormation(formation $formation): self
    {
        if (!$this->formations->contains($formation)) {
            $this->formations->add($formation);
        }

        return $this;
    }

    public function removeFormation(formation $formation): self
    {
        $this->formations->removeElement($formation);

        return $this;
    }

    /**
     * @return Collection<int, experience>
     */
    public function getExperiences(): Collection
    {
        return $this->experiences;
    }

    public function addExperience(experience $experience): self
    {
        if (!$this->experiences->contains($experience)) {
            $this->experiences->add($experience);
        }

        return $this;
    }

    public function removeExperience(experience $experience): self
    {
        $this->experiences->removeElement($experience);

        return $this;
    }

    /**
     * @return Collection<int, project>
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
        }

        return $this;
    }

    public function removeProject(project $project): self
    {
        $this->projects->removeElement($project);

        return $this;
    }

}
