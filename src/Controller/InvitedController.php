<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class InvitedController extends Controller
{
    /**
     * @Route("/invited", name="invited")
     */
    public function index()
    {
        return $this->render('invited/index.html.twig', [
            'controller_name' => 'InvitedController',
        ]);
    }
}
