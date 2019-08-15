<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Dirty hack to make React App work with Symfony :(
 *
 * @package App\Controller
 */
class UIController extends Controller
{
    public function __construct(SessionInterface $session)
    {
        // TODO remove it and implement authentication
        $userId = $session->get('userId');
        if (!$userId) {
            $session->set('userId', 1);
        }
    }

    /**
     * @route("/", name="UI")
     */
    public function index() {
        return $this->render('ui/index.html');
    }
}