<?php

namespace App\Services;

use App\Entity\Sorties;
use App\Repository\EtatsRepository;
use App\Repository\SortiesRepository;
use Symfony\Component\Validator\Constraints\Date;

class StateEventUpdate
{
    public function setUpdatedEventState(SortiesRepository $sortiesRepository, EtatsRepository $etatsRepository)
    {
        //get all events
        $allSorties = $sortiesRepository->findAll();
        $currentDate = new \DateTime('now');

        //update each event's state
        foreach ($allSorties as $currentSortie){
            if (sizeof($currentSortie->getInscriptions()) >= $currentSortie->getNbInscriptionsmax() OR $currentDate > $currentSortie->getDateCloture())
            {
                //set cloturée
                $currentSortie->setEtat($etatsRepository->find(3));
            }

            if ($currentDate === $currentSortie->getDateDebut())
            {
                //set activité en cours
                $currentSortie->setEtat($etatsRepository->find(4));
            }

            if ($currentDate > $currentSortie->getDateDebut())
            {
                //set passée
                $currentSortie->setEtat($etatsRepository->find(5));
            }
        }

    }
}