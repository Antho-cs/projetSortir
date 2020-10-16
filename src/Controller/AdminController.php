<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\Villes;
use App\Form\AddCampusType;
use App\Form\AddVillesType;
use App\Form\RechercheCampusType;
use App\Form\RechercheVilleType;
use App\Repository\CampusRepository;
use App\Repository\VillesRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
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
    public function editVilles(Request $request, VillesRepository $villesRepository, EntityManagerInterface $em)
    {
        $villesForm = $this->createForm(RechercheVilleType::class);
        $villesForm->handleRequest($request);

        $addVillesForm = $this->createForm(AddVillesType::class);
        $addVillesForm->handleRequest($request);

        if($villesForm->isSubmitted() && $villesForm->isValid()){
            $recherche = $villesForm['nomVille']->getData();
            $listeVilles = $villesRepository->contains($recherche);
        } else {
            $listeVilles = $villesRepository->findAll();
        }

        if ($addVillesForm->isSubmitted() && $addVillesForm->isValid()) {
            $newVilles = new Villes();
            $nomVille = $addVillesForm['nomVille']->getData();
            $codePostal = $addVillesForm['codePostal']->getData();
            $newVilles->setNomVille($nomVille);
            $newVilles->setCodePostal($codePostal);
            $em->persist($newVilles);
            $em->flush();
            $this->addFlash('success', 'La ville a bien été créé !');

            return $this->redirectToRoute('edit_villes');
        }

        return $this->render('admin/editvilles.html.twig', [
            'controller_name' => 'AdminController',
            'listeVilles' => $listeVilles,
            'villesForm' => $villesForm->createView(),
            'addVillesForm' => $addVillesForm->createView()
        ]);
    }

    /**
     * @Route ("/campus", name="edit_campus")
     */
    public function editCampus(Request $request, CampusRepository $campusRepository, EntityManagerInterface $em)
    {
        $campusForm = $this->createForm(RechercheCampusType::class);
        $campusForm->handleRequest($request);

        $addCampusForm = $this->createForm(AddCampusType::class);
        $addCampusForm->handleRequest($request);

        if($campusForm->isSubmitted() && $campusForm->isValid()){
            $recherche = $campusForm['nomCampus']->getData();
            $listeCampus = $campusRepository->contains($recherche);
        } else {
            $listeCampus = $campusRepository->findAll();
        }

        if ($addCampusForm->isSubmitted() && $addCampusForm->isValid()) {
            $newCampus = new Campus();
            $nomCampus = $addCampusForm['nomCampus']->getData();
            $newCampus->setNomCampus($nomCampus);
            $em->persist($newCampus);
            $em->flush();
            $this->addFlash('success', 'Le campus est bien créé !');

            return $this->redirectToRoute('edit_campus');
        }

        return $this->render('admin/editcampus.html.twig', [
            'controller_name' => 'AdminController',
            'listeCampus' => $listeCampus,
            'campusForm' => $campusForm->createView(),
            'addCampusForm' => $addCampusForm->createView()
        ]);
    }
}
