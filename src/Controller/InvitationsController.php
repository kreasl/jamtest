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
        $entityManager = $this->getDoctrine()->getManager();

        $senderId = $this->get('session')->get('userId');

        $sender = $this->getDoctrine()->getRepository(User::class)->findOneById($senderId);
        $receiver = $this->getDoctrine()->getRepository(User::class)->findOneById($userId);

        $invitation = new Invitation();
        $invitation->setSenderId($sender);
        $invitation->setInvitedId($receiver);

        $entityManager->persist($invitation);
        $entityManager->flush();

        return $this->redirectToRoute('invitationOperationSuccess');
    }

    /**
     * @Route("/invitations/accept/{invitationId}", name="acceptInvitation")
     */
    public function accept($invitationId)
    {
        $invitation = $this->getDoctrine()->getRepository(Invitation::class)->findOneById($invitationId);
        $entityManager = $this->getDoctrine()->getManager();

        $invitation->setStatus(Invitation::STATUS_ACCEPTED);

        $entityManager->persist($invitation);
        $entityManager->flush();

        return $this->redirectToRoute('invitationOperationSuccess');
    }

    /**
     * @Route("/invitations/decline/{invitationId}", name="declineInvitation")
     */
    public function decline($invitationId)
    {
        $invitation = $this->getDoctrine()->getRepository(Invitation::class)->findOneById($invitationId);
        $entityManager = $this->getDoctrine()->getManager();

        $invitation->setStatus(Invitation::STATUS_DECLINED);

        $entityManager->persist($invitation);
        $entityManager->flush();

        return $this->redirectToRoute('invitationOperationSuccess');
    }

    /**
     * @Route("/invitations/success/", name="invitationOperationSuccess")
     */
    public function success()
    {
        $userId = $this->get('session')->get('userId');

        return $this->render('invitations/success.html.twig', [
            'backLink' => $this->generateUrl('userDetails', ['userId' => $userId])
        ]);
    }
}
