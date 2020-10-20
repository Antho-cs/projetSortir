<?php

namespace App\Controller;

use App\Entity\Inscriptions;
use App\Entity\Sorties;
use App\Repository\InscriptionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class InscriptionToEventController extends AbstractController
{
    /**
     * @Route("/inscription/{id}", name="inscription_to_event")
     */
    public function suscribe(Sorties $sortie, EntityManagerInterface $entityManager)
    {
        $inscription = new Inscriptions();

        //set inscription instance
        $inscription->setDateInscription(new \DateTime());
        //organisateur ne voit pas le btn dont supposons que le check supplémentaire n'est pas important
        $inscription->setParticipant($this->getUser());
        $inscription->setSortie($sortie);

        $entityManager->persist($inscription);
        $entityManager->flush();

        $this->addFlash('success', 'Vous êtes bien inscrit-e sur l\'événement');


        return $this->redirectToRoute('home');
    }


    /**
     * @Route("/sedesister/{id}", name="reject_inscription")
     */
    public function rejectInscription(Sorties $sortie, InscriptionsRepository $repository, EntityManagerInterface $entityManager)
    {

        //get inscription*
        $inscriptionToRemove = null;
        $arrayInscriptions = $sortie->getInscriptions();

        //check if the user is participant and keep the inscription
        for ($i = 0; $i<sizeof($arrayInscriptions); $i++){
            if($arrayInscriptions[$i]->getParticipant() == $this->getUser()){
                $inscriptionToRemove = $arrayInscriptions[$i];
            }
        }

        //remove inscription
        $entityManager->remove($inscriptionToRemove);
        $entityManager->flush();

        $this->addFlash('success', 'Votre inscription a bien été annulée!');


        return $this->redirectToRoute('home');
    }
}
