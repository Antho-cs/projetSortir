<?php

namespace App\Controller;

use App\Entity\Participants;
use App\Form\UpProfileUserFormType;
use App\Repository\CampusRepository;
use App\Repository\ParticipantsRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use http\Client\Curl\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

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
    public function displayProfile(int $id, ParticipantsRepository $participant)
    {

        $currentUser = $participant->find($id);
        return $this->render('users/profile.html.twig', [
            'controller_name' => 'UsersController',
            'currentUser' => $currentUser
        ]);
    }

    /**
     * @Route("/update/{id}", priority="10", name="update_user")
     */
    public function updateUser(Participants $participant, Request $request, CampusRepository $campusRepository)
    {
        $em = $this->getDoctrine()->getManager();
        $campus = $campusRepository->findAll();


        $form = $this->createForm(UpProfileUserFormType::class, $participant);

        $form ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            //btn enregistrer
            if($form->getClickedButton() === $form->get('enregistrer')) {

            $em->persist($participant);
            $em->flush();
            $this->addFlash('success', 'Votre profil a bien été mis à jour!');

            return $this->redirectToRoute('home');
            }
            //btn retour
            if($form->getClickedButton() === $form->get('retour')) {
                return $this->redirectToRoute(('home'));
            }
        }

        return $this->render('/users/upprofile.html.twig', [
            'upProfilUserFormType' => $form->createView(), 'campus' => $campus
        ]);
    }



}
