<?php

namespace App\Controller;

use App\Entity\Participants;
use App\Form\UpProfileUserFormType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function updateUser(Participants $participant, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(UpProfileUserFormType::class);

        $form ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $participant = $form->getData();

            $em->persist($participant);
            $em->flush();

            $this->addFlash('Bravo', 'Votre profil a bien été mis à jour!');

            return $this->redirectToRoute('/');
        }

        return $this->render('/users/upprofile.html.twig', [
            'upProfilUserFormType' => $form->createView()
        ]);
    }
}
