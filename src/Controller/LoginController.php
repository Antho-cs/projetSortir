<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    /**
     * @Route("/", name="landing")
     */
    public function landing()
    {
        return $this->render('login/login.html.twig');
    }
}
