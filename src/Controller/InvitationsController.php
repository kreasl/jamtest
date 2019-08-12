<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Invitation;

class InvitationsController extends Controller
{
    /**
     * @Route("/invitations/sent/{userId}", name="sentInvitations")
     */
    public function sent($userId)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneById($userId);
        $invitations = $user->getSentInvitations();

        return $this->render('invitations/sent.html.twig', [
            'user' => $user,
            'invitations' => $invitations,
        ]);
    }

    /**
     * @Route("/invitations/received/{userId}", name="receivedInvitations")
     */
    public function received($userId)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneById($userId);
        $invitations = $user->getReceivedInvitations();

        return $this->render('invitations/received.html.twig', [
            'user' => $user,
            'invitations' => $invitations,
        ]);
    }

    /**
     * @Route("/invitations/send/{userId}", name="sendInvitation")
     */
    public function send($userId)
    {
        return $this->render('invitations/success.html.twig');
    }

    /**
     * @Route("/invitations/accept/{invitationId}", name="acceptInvitation")
     */
    public function accept($invitationId)
    {
        return $this->render('invitations/success.html.twig');
    }

    /**
     * @Route("/invitations/decline/{invitationId}", name="declineInvitation")
     */
    public function decline($invitationId)
    {
        return $this->render('invitations/success.html.twig');
    }
}
