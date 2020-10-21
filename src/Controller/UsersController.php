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
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
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
    public function updateUser(Participants $participant, Request $request, CampusRepository $campusRepository, UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();
        $campus = $campusRepository->findAll();


        $form = $this->createForm(UpProfileUserFormType::class, $participant);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //btn enregistrer
            if ($form->getClickedButton() === $form->get('enregistrer')) {



                    $password = $form['password']->getData();
                    $encoded = $encoder->encodePassword($participant, $password);
                    $participant->setPassword($encoded);
              
                if (!empty($form->get('urlPhoto')->getData())) {

                    $img = $form->get('urlPhoto')->getData();
                    $newFileName = sha1(uniqid()) . '.' . $img->guessExtension();
                    $img->move($this->getParameter('img_directory'), $newFileName);
                    $participant->setUrlPhoto($newFileName);
                }

                $em->persist($participant);
                $em->flush();
                $this->addFlash('success', 'Votre profil a bien été mis à jour!');

                return $this->redirectToRoute('home');
            }
            //btn retour
            if ($form->getClickedButton() === $form->get('retour')) {
                return $this->redirectToRoute(('home'));
            }
        }

        return $this->render('/users/upprofile.html.twig', [
            'upProfilUserFormType' => $form->createView(), 'campus' => $campus
        ]);
    }
}
