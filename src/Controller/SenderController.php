<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class SenderController extends Controller
{
    /**
     * @Route("/sender", name="sender")
     */
    public function index()
    {
        return $this->render('sender/index.html.twig', [
            'controller_name' => 'SenderController',
        ]);
    }
}
