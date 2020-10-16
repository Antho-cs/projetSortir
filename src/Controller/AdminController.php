<?php

namespace App\Controller;

use App\Form\RechercheCampusType;
use App\Form\RechercheVilleType;
use App\Repository\CampusRepository;
use App\Repository\VillesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function editVilles(Request $request, VillesRepository $villesRepository)
    {
        $villesForm = $this->createForm(RechercheVilleType::class);
        $villesForm->handleRequest($request);

        if($villesForm->isSubmitted() && $villesForm->isValid()){
            $recherche = $villesForm['nomVille']->getData();
            $listeVilles = $villesRepository->contains($recherche);
        } else {
            $listeVilles = $villesRepository->findAll();
        }

        return $this->render('admin/editvilles.html.twig', [
            'controller_name' => 'AdminController',
            'listeVilles' => $listeVilles,
            'villesForm' => $villesForm->createView()
        ]);
    }

    /**
     * @Route ("/campus", name="edit_campus")
     */
    public function editCampus(Request $request, CampusRepository $campusRepository)
    {
        $campusForm = $this->createForm(RechercheCampusType::class);
        $campusForm->handleRequest($request);

        if($campusForm->isSubmitted() && $campusForm->isValid()){
            $recherche = $campusForm['nomCampus']->getData();
            $listeCampus = $campusRepository->contains($recherche);
        } else {
            $listeCampus = $campusRepository->findAll();
        }
        return $this->render('admin/editcampus.html.twig', [
            'controller_name' => 'AdminController',
            'listeCampus' => $listeCampus,
            'campusForm' => $campusForm->createView()
        ]);
    }
}
