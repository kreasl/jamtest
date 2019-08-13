<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends Controller
{

    /**
     * @Route("/login/{userId}", name="login")
     */
    public function login($userId)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneById($userId);

        $this->get('session')->set('userId', $userId);

        return $this->render('auth/login.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        $this->container->get('session')->invalidate();

        return $this->render('auth/logout.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }
}
