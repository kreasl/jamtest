<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Invitation;

class InvitationsController extends Controller
{
    /**
     * @Route("/invitations/send", name="sendInvitation")
     */
    public function send(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $entityManager = $this->getDoctrine()->getManager();

        $senderId = $data['senderId'] ?? $this->get('session')->get('userId');
        $receiverId = $data['receiverId'];
        $message = $data['message'] ?? '';

        $sender = $this->getDoctrine()->getRepository(User::class)->findOneById($senderId);
        $receiver = $this->getDoctrine()->getRepository(User::class)->findOneById($receiverId);

        $invitation = new Invitation();
        $invitation->setSenderId($sender);
        $invitation->setInvitedId($receiver);
        $invitation->setMessage($message);

        $entityManager->persist($invitation);
        $entityManager->flush();

        return $this->json(['success' => true]);
    }

    /**
     * @Route("/invitations/{invitationId}/accept", name="acceptInvitation")
     */
    public function accept($invitationId)
    {
        $invitation = $this->getDoctrine()->getRepository(Invitation::class)->findOneById($invitationId);
        $entityManager = $this->getDoctrine()->getManager();

        $invitation->setStatus(Invitation::STATUS_ACCEPTED);

        $entityManager->persist($invitation);
        $entityManager->flush();

        return $this->json(['success' => true]);
    }

    /**
     * @Route("/invitations/{invitationId}/decline", name="declineInvitation")
     */
    public function decline($invitationId)
    {
        $invitation = $this->getDoctrine()->getRepository(Invitation::class)->findOneById($invitationId);
        $entityManager = $this->getDoctrine()->getManager();

        $invitation->setStatus(Invitation::STATUS_DECLINED);

        $entityManager->persist($invitation);
        $entityManager->flush();

        return $this->json(['success' => true]);
    }

    /**
     * @Route("/invitations/{invitationId}/cancel", name="declineInvitation")
     */
    public function cancel($invitationId)
    {
        $invitation = $this->getDoctrine()->getRepository(Invitation::class)->findOneById($invitationId);
        $entityManager = $this->getDoctrine()->getManager();

        $invitation->setStatus(Invitation::STATUS_DECLINED);

        $entityManager->persist($invitation);
        $entityManager->flush();

        return $this->json(['success' => true]);
    }
}
