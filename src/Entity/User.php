<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Invitation", mappedBy="sender", orphanRemoval=true)
     */
    private $sentInvitations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Invitation", mappedBy="invited", orphanRemoval=true)
     */
    private $receivedInvitations;

    public function __construct()
    {
        $this->sentInvitations = new ArrayCollection();
        $this->receivedInvitations = new ArrayCollection();
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

    /**
     * @return Collection|Invitation[]
     */
    public function getSentInvitations(): Collection
    {
        return $this->sentInvitations;
    }

    public function addSentInvitation(Invitation $sentInvitation): self
    {
        if (!$this->sentInvitations->contains($sentInvitation)) {
            $this->sentInvitations[] = $sentInvitation;
            $sentInvitation->setSenderId($this);
        }

        return $this;
    }

    public function removeSentInvitation(Invitation $sentInvitation): self
    {
        if ($this->sentInvitations->contains($sentInvitation)) {
            $this->sentInvitations->removeElement($sentInvitation);
            // set the owning side to null (unless already changed)
            if ($sentInvitation->getSenderId() === $this) {
                $sentInvitation->setSenderId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Invitation[]
     */
    public function getReceivedInvitations(): Collection
    {
        return $this->receivedInvitations;
    }

    public function addReceivedInvitation(Invitation $receivedInvitation): self
    {
        if (!$this->receivedInvitations->contains($receivedInvitation)) {
            $this->receivedInvitations[] = $receivedInvitation;
            $receivedInvitation->setInvitedId($this);
        }

        return $this;
    }

    public function removeReceivedInvitation(Invitation $receivedInvitation): self
    {
        if ($this->receivedInvitations->contains($receivedInvitation)) {
            $this->receivedInvitations->removeElement($receivedInvitation);
            // set the owning side to null (unless already changed)
            if ($receivedInvitation->getInvitedId() === $this) {
                $receivedInvitation->setInvitedId(null);
            }
        }

        return $this;
    }
}
