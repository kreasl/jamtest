<?php

namespace App\Controller;

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

        return $this->render('users/index.html.twig', [
            'users' => $users,
        ]);
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

        return $this->render('users/details.html.twig', [
            'user' => $user,
            'sentCount' => $sentCount,
            'receivedCount' => $receivedCount,
        ]);
    }
}
