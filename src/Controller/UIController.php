<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Dirty hack to make React App work with Symfony :(
 *
 * @package App\Controller
 */
class UIController extends Controller
{
    /**
     * @route("/", name="UI")
     */
    public function index() {
        return $this->render('ui/index.html');
    }
}