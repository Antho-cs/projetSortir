<?php

namespace App\Controller;

use App\Entity\Etats;
use App\Entity\Lieux;
use App\Entity\Sorties;
use App\Form\DisableEventType;
use App\Form\EventType;
use App\Form\HomeType;
use App\Form\LieuType;
use App\Form\UpdateEventType;
use App\Repository\CampusRepository;
use App\Repository\SortiesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EventController
 * @package App\Controller
 * @Route("/event")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(Request $request, CampusRepository $campusRepository, SortiesRepository $sortiesRepository)
    {
        $homeForm = $this->createForm(HomeType::class);
        $homeForm->handleRequest($request);
        $sortie = new Sorties();
        $rechercheNom = null;

        // Tout les campus //
        $campus = $campusRepository->findAll();
        // Toutes les sorties //
        $sorties = $sortiesRepository->findAll();

        if ($homeForm->isSubmitted() && $homeForm->isValid()) {
            $rechercheNom = $homeForm['nomSortie']->getData();
            $rechercheCampus = $homeForm['campus']->getData();
            $dateDebut = $homeForm['datedebut']->getData();
            $dateCloture = $homeForm['datecloture']->getData();
            if ($rechercheNom != null) {
                $sorties = $sortiesRepository->contains($rechercheNom);
            }
            if ($rechercheCampus != null) {
                $sorties = $sortiesRepository->findBy(['campus'=>$rechercheCampus]);
            }
            if ($dateDebut != null || $dateCloture != null) {
                $sorties = $sortiesRepository->findByDate($dateDebut,$dateCloture);
            }
        }

        //TODO Ecrire la fonction

        return $this->render('event/home.html.twig', ['controller_name' => 'EventController',
            'campus' => $campus,
            'sorties' => $sorties,
            'homeform' => $homeForm->createView()
        ]);
    }

    /**
     * @Route("/create", name="create_event")
     */
    public function createEvent(Request $request, EntityManagerInterface $em)
    {
        //créer une entité vide
        $newEvent = new Sorties();

        //créer le formulaire
        $eventForm = $this->createForm(EventType::class, $newEvent);

        // $lieuForm->handleRequest($request);
        $eventForm->handleRequest($request);

        if ($eventForm->isSubmitted() && $eventForm->isValid()) {

            /*
             * btn enregistrer
             * set event's state as created
             * redirect to 'home'
             * stock the event into a bdd
             * */
            if ($eventForm->getClickedButton() === $eventForm->get('enregistrer')) {
                //set created state
                $newEvent->setEtat($this->getDoctrine()->getRepository(Etats::class)->find(1));
                $newEvent->setOrganisateur($this->getUser());

                $em->persist($newEvent);
                $em->flush();
                $this->addFlash('success', 'La sortie est bien créée!');

                return $this->redirectToRoute('home');
            }

            /*  btn publier
             * set event's state as open
             * redirect to 'home'
             * stock the event into a bdd
             * */
            if ($eventForm->getClickedButton() === $eventForm->get('publier')) {
                //set created state
                $newEvent->setEtat($this->getDoctrine()->getRepository(Etats::class)->find(2));
                $newEvent->setOrganisateur($this->getUser());

                $em->persist($newEvent);
                $em->flush();
                $this->addFlash('success', 'La sortie est bien publiée!');

                return $this->redirectToRoute('home');
            }

            /*
             * btn annuler
             * redirect to 'home'
             * */
            if ($eventForm->getClickedButton() === $eventForm->get('annuler')) {

                $this->addFlash('alert ', 'La sortie est annulée!');
                return $this->render('user/profile.html.twig');
            }
        }
        return $this->render('event/createEvent.html.twig', [
            'eventForm' => $eventForm->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="event")
     */
    public function event(Sorties $sortie, SortiesRepository $sortiesRepository)
    {
        return $this->render('event/event.html.twig', [
            'controller_name' => 'EventController',
        ]);
    }

    /**
     * @Route("/update/{id}", name="update_event")
     */
    public function updateEvent(Sorties $sortie, SortiesRepository $sortiesRepository, Request $request, EntityManagerInterface $em)
    {
        //get state's id and put it into the twig for display or nor the btn publier
        $etatSortie = $sortie->getEtat()->getId();
        $updateEventForm = $this->createForm(UpdateEventType::class, $sortie);

        $updateEventForm->handleRequest($request);

        if ($updateEventForm->isSubmitted() && $updateEventForm->isValid()) {

            /*
             * btn enregistrer
             * update an event
             * redirect to 'home'
             * */
            if ($updateEventForm->getClickedButton() === $updateEventForm->get('enregistrer')) {
                //set created state

                $em->persist($sortie);
                $em->flush();
                $this->addFlash('success', 'Les modifications sont bien enregistrées!');

                return $this->redirectToRoute('home');
            }

            /*  btn publier just for non-published events
             * set event's state as open and changed values
             * redirect to 'home'
             * */
            if ($updateEventForm->getClickedButton() === $updateEventForm->get('publier')) {
                //set created state
                $sortie->setEtat($this->getDoctrine()->getRepository(Etats::class)->find(2));
                $em->persist($sortie);
                $em->flush();
                $this->addFlash('success', 'La sortie est bien publiée!');

                return $this->redirectToRoute('home');
            }

            /*
             * btn supprimer
             * redirect to 'home'
             * */
            if ($updateEventForm->getClickedButton() === $updateEventForm->get('supprimer')) {
                $em->remove($sortie);
                $em->flush();
                $this->addFlash('success ', 'La sortie est supprimée!');
                return $this->redirectToRoute('home');
            }

            /*
             * btn annuler
             * redirect to 'home'
             * */
            if ($updateEventForm->getClickedButton() === $updateEventForm->get('retourner')) {

                $this->addFlash('alert ', 'Les modifications de la sortie ne sont pas prises en compte!');
                return $this->redirectToRoute('home');
            }

        }

        return $this->render('event/updateEvent.html.twig', [
            'updateSortieForm' => $updateEventForm->createView(),
            'idEtatSortie' => $etatSortie,
            'sortie' => $sortie
        ]);
    }
    /*
     * set event's state to annulée
     */

    /**
     * @Route("/annuler/{id}", name="cancel_event")
     */
    public function disableEvent(Sorties $sortie, Request $request, EntityManagerInterface $entity)
    {
        $disableEventForm = $this->createForm(DisableEventType::class, $sortie);

        $disableEventForm->handleRequest($request);

        /*
         * btn valider
         * set event's state to annulée
         * redirect to home with message flash
         * */
        if ($disableEventForm->getClickedButton() === $disableEventForm->get('valider')) {

            $entity->persist($sortie);
            $entity->flush();

            $this->addFlash('success ', 'La sortie est annulée!');

            return $this->redirectToRoute('home');
        }

        /*
        * btn Retour
         * without updating
        * redirect to home with message flash
        * */
        if ($disableEventForm->getClickedButton() === $disableEventForm->get('retour')) {
            $this->addFlash('alert ', 'Les changements ne sont pas pris en compte!');
            return $this->redirectToRoute('home');
        }

        return $this->render('event/disableEvent.html.twig', [
            'disableEventForm' => $disableEventForm->createView(),
            'sortie' => $sortie
        ]);

    }
}
