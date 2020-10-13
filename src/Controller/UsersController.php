<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UsersController
 * @package App\Controller
 * @Route("/users")
 */
class UsersController extends AbstractController
{
    /**
     * @Route("/{id}", name="user")
     */
    public function displayProfile() //TODO Injecter l'ID
    {
        //TODO Ecrire la fonction
        return $this->render('users/profile.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }

    /**
     * @Route("/update/{id}", name="update_user")
     */
    public function updateUser() //TODO Injecter l'ID
    {
        //TODO Ecrire la fonction
        return $this->render('users/upprofile.html.twig', [
            'controller_name' => 'UsersController',
        ]);
    }
}
