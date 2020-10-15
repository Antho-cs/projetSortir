<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BtnSortieCreationController extends AbstractController
{
    /*
     * annuler event's creation
     * redirect to home
     */
    /**
     * @Route("/cancel/creation", name="btn_sortie_creation")
     */
    public function cancel()
    {
        return $this->render('btn_sortie_creation/index.html.twig', [
            'controller_name' => 'BtnSortieCreationController',
        ]);
    }

    /*
     * create an event
     * set event's state as open
     */
    /**
     *@Route("/publish", name="set_open")
     */
    public function publish(){

    }
}
