<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\Participants;
use App\Entity\Villes;
use App\Form\AddCampusType;
use App\Form\AddUserType;
use App\Form\AddVillesType;
use App\Form\DeleteCampusType;
use App\Form\DeleteVillesType;
use App\Form\RechercheCampusType;
use App\Form\RechercheVilleType;
use App\Form\UpdateCampusType;
use App\Form\UpdateVillesType;
use App\Form\UpProfileUserFormType;
use App\Repository\CampusRepository;
use App\Repository\VillesRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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


        //Recherche de villes
        if ($villesForm->isSubmitted() && $villesForm->isValid()) {
            $recherche = $villesForm['nomVille']->getData();
            $listeVilles = $villesRepository->contains($recherche);
        } else {
            $listeVilles = $villesRepository->findAll();
        }

        //Ajout de ville
        if ($addVillesForm->isSubmitted() && $addVillesForm->isValid()) {
            $newVilles = new Villes();
            $nomVille = $addVillesForm['nomVille']->getData();
            $codePostal = $addVillesForm['codePostal']->getData();
            $newVilles->setNomVille($nomVille);
            $newVilles->setCodePostal($codePostal);
            $em->persist($newVilles);
            $em->flush();
            $this->addFlash('success', 'La ville a bien ??t?? cr????e !');


            return $this->redirectToRoute('edit_villes');
        }

        return $this->render('admin/editvilles.html.twig', [
            'controller_name' => 'AdminController',
            'listeVilles' => $listeVilles,
            'villesForm' => $villesForm->createView(),
            'addVillesForm' => $addVillesForm->createView(),
        ]);
    }

    /**
     * @Route ("/villes/delete/{id}", name="del_villes")
     */
    public function delVille(int $id, Request $request, VillesRepository $villesRepository, EntityManagerInterface $em)
    {
        $deleteVillesForm = $this->createForm(DeleteVillesType::class);
        $deleteVillesForm->handleRequest($request);

        //Suppression de ville
        if ($deleteVillesForm->isSubmitted() && $deleteVillesForm->isValid()) {
            $villeASupp = $villesRepository->find($id);
            $em->remove($villeASupp);
            $em->flush();
            $this->addFlash('warning', 'La ville a bien ??t?? supprim??e !');
            return $this->redirectToRoute('edit_villes');
        }
        return $this->render('admin/delvilles.html.twig', [
            'controller_name' => 'AdminController',
            'deleteVillesForm' => $deleteVillesForm->createView()
        ]);
    }

    /**
     * @Route ("/villes/update/{id}", name="up_villes")
     */
    public function upVille(int $id, Request $request, VillesRepository $villesRepository, EntityManagerInterface $em)
    {
        $villeAUp = $villesRepository->find($id);
        $updateVillesForm = $this->createForm(UpdateVillesType::class);
        $updateVillesForm->handleRequest($request);

        //Suppression de ville
        if ($updateVillesForm->isSubmitted() && $updateVillesForm->isValid()) {
            $nouveauNom = $updateVillesForm['nomVille']->getData();
            $nouveauCP = $updateVillesForm['codePostal']->getData();

            $villeAUp->setNomVille($nouveauNom);
            $villeAUp->setCodePostal($nouveauCP);

            $em->persist($villeAUp);
            $em->flush();
            $this->addFlash('warning', 'La ville a bien ??t?? modifi??e !');
            return $this->redirectToRoute('edit_villes');
        }
        return $this->render('admin/upvilles.html.twig', [
            'controller_name' => 'AdminController',
            'ville' => $villeAUp,
            'updateVillesForm' => $updateVillesForm->createView()
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

        if ($campusForm->isSubmitted() && $campusForm->isValid()) {
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
            $this->addFlash('success', 'Le campus est bien cr???? !');

            return $this->redirectToRoute('edit_campus');
        }

        return $this->render('admin/editcampus.html.twig', [
            'controller_name' => 'AdminController',
            'listeCampus' => $listeCampus,
            'campusForm' => $campusForm->createView(),
            'addCampusForm' => $addCampusForm->createView()
        ]);
    }

    /**
     * @Route ("/campus/delete/{id}", name="del_campus")
     */
    public function delCampus(int $id, Request $request, CampusRepository $campusRepository, EntityManagerInterface $em)
    {
        $deleteCampusForm = $this->createForm(DeleteCampusType::class);
        $deleteCampusForm->handleRequest($request);

        //Suppression de ville
        if ($deleteCampusForm->isSubmitted() && $deleteCampusForm->isValid()) {
            $campusASupp = $campusRepository->find($id);
            $em->remove($campusASupp);
            $em->flush();
            $this->addFlash('warning', 'Le campus a bien ??t?? supprim?? !');
            return $this->redirectToRoute('edit_campus');
        }
        return $this->render('admin/delcampus.html.twig', [
            'controller_name' => 'AdminController',
            'deleteCampusForm' => $deleteCampusForm->createView()
        ]);
    }

    /**
     * @Route ("/campus/update/{id}", name="up_campus")
     */
    public function upCampus(int $id, Request $request, CampusRepository $campusRepository, EntityManagerInterface $em)
    {
        $campusAUp = $campusRepository->find($id);
        $updateCampusForm = $this->createForm(UpdateCampusType::class);
        $updateCampusForm->handleRequest($request);

        //Suppression de ville
        if ($updateCampusForm->isSubmitted() && $updateCampusForm->isValid()) {
            $nouveauNom = $updateCampusForm['nomCampus']->getData();
            $campusAUp->setNomCampus($nouveauNom);

            $em->persist($campusAUp);
            $em->flush();
            $this->addFlash('warning', 'Le campus a bien ??t?? modifi?? !');
            return $this->redirectToRoute('edit_campus');
        }
        return $this->render('admin/upcampus.html.twig', [
            'controller_name' => 'AdminController',
            'campus' => $campusAUp,
            'updateCampusForm' => $updateCampusForm->createView()
        ]);
    }

    /**
     * @Route("/create_User", name="create_users")
     */
    public function createUser(Request $request, EntityManagerInterface $em, CampusRepository  $campusRepository, UserPasswordEncoderInterface $encoder)
    {
        //cr??er une entit?? vide
        $newUser = new Participants();

        // Les Campus //
        $campus = $campusRepository->findAll();

        //cr??er le formulaire
        $userForm = $this->createForm(AddUserType::class, $newUser);


        $newUser->setAdministrateur(false);
        $newUser->setActif(true);


        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $newUser->setRoles([$userForm->get('role')->getData()]);

            if ($userForm->getClickedButton() === $userForm->get('enregistrer')) {

                $password =$userForm['password']->getData();
                $encoded = $encoder->encodePassword($newUser, $password);
                $newUser->setPassword($encoded);

                $em->persist($newUser);
                $em->flush();
                $this->addFlash('success', 'Un nouvel utilisateur a bien ??t?? cr????!');

                return $this->redirectToRoute('home');
            }

            //btn retour
            if($userForm->getClickedButton() === $userForm->get('retour')) {
                return $this->redirectToRoute(('home'));
            }

        }
        return $this->render('admin/editUser.html.twig', [
            'userForm' => $userForm->createView(), 'campus' => $campus
        ]);
    }

}
