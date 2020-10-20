<?php

namespace App\Controller;

use App\Entity\Etats;
use App\Entity\Sorties;
use App\Repository\ParticipantsRepository;
use App\Repository\SortiesRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PublishController extends AbstractController
{
    /**
     * @Route("/publish/{id}", name="publish")
     */
    public function publish(EntityManagerInterface $em, int $id, SortiesRepository $sortiesRepository)
    {
        //récupérer l'entité courante via son ID //
        $currentEvent = $sortiesRepository->find($id);

        $currentEvent->setEtat($this->getDoctrine()->getRepository(Etats::class)->find(2));
        $currentEvent->setOrganisateur($this->getUser());

        $em->persist($currentEvent);
        $em->flush();
        $this->addFlash('success', 'La sortie est bien publiée!');

        return $this->redirectToRoute('home');
    }
}
