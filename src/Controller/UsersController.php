<?php

namespace App\Controller;

use App\Entity\Invitation;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends Controller
{
    /**
     * @Route("/users", name="users")
     */
    public function index()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        $cleanUsers = array_map([$this, 'obfuscateUser'], $users);

        return $this->json($cleanUsers);
    }

    /**
     * @param int $id
     *
     * @Route("/users/{userId}", name="userDetails")
     */
    public function details($userId)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneById($userId);
        $sentCount = $user->getSentInvitations()->count();
        $receivedCount = $user->getReceivedInvitations()->count();

        return $this->json([
            'user' => $this->obfuscateUser($user),
            'sentCount' => $sentCount,
            'receivedCount' => $receivedCount,
        ]);
    }


    /**
     * @Route("/users/{userId}/invitations/sent", name="sentInvitations")
     */
    public function sent($userId)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneById($userId);
        $invitations = $user->getSentInvitations()->getValues();
        $cleanInvitations = array_map([$this, 'obfuscateInvitation'], $invitations);

        return $this->json([
            'user' => $this->obfuscateUser($user),
            'invitations' => $cleanInvitations,
        ]);
    }

    /**
     * @Route("/users/{userId}/invitations/received", name="receivedInvitations")
     */
    public function received($userId)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneById($userId);
        $invitations = $user->getReceivedInvitations()->getValues();
        $cleanInvitations = array_map([$this, 'obfuscateInvitation'], $invitations);

        return $this->json([
            'user' => $this->obfuscateUser($user),
            'invitations' => $cleanInvitations,
        ]);
    }

    protected function obfuscateUser(User $user) {
        return [
            'id' => $user->getId(),
            'name' => $user->getName(),
        ];
    }

    protected function obfuscateInvitation(Invitation $invitation) {
        return [
            'id' => $invitation->getId(),
            'created' => $invitation->getCreated(),
        ];
    }
}
