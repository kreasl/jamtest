<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InvitationRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Invitation
{
    public const STATUS_CREATED = 0;
    public const STATUS_ACCEPTED = 1;
    public const STATUS_DECLINED = 10;
    public const STATUS_CANCELED = 20;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="sentInvitations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sender;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="receivedInvitations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $invited;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $message;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSenderId(): ?User
    {
        return $this->sender;
    }

    public function setSenderId(?User $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getInvitedId(): ?User
    {
        return $this->invited;
    }

    public function setInvitedId(?User $invited): self
    {
        $this->invited = $invited;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage($message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    /**
     * @ORM\PrePersist
     */
    public function onCreate() {
        $this->status = self::STATUS_CREATED;
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function onUpdate() {
        $this->updated = new \DateTime();
    }
}
