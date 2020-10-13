<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package App\Controller
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route ("/villes", name="edit_villes")
     */
    public function editVilles()
    {
        return $this->render('admin/editvilles.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route ("/campus", name="edit_campus")
     */
    public function editCampus()
    {
        return $this->render('admin/editcampus.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
