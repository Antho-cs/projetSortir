<?php

namespace App\Services;

use App\Entity\Sorties;
use App\Repository\EtatsRepository;
use App\Repository\SortiesRepository;
use Symfony\Component\Validator\Constraints\Date;

class StateEventUpdate
{
    private $sortiesRepository;
    private $etatsRepository;
    private $converter;

    public function __construct(SortiesRepository $sortiesRepository, EtatsRepository $etatsRepository)
    {
        $this->sortiesRepository = $sortiesRepository;
        $this->etatsRepository = $etatsRepository;
    }

    public function setUpdatedEventState()
    {
        $converter = $this->converter;
        $sortiesRepository = $this->sortiesRepository;
        //get all events
        $allSorties = $sortiesRepository->findAll();
        $currentDate = new \DateTime('now');


        //update each event's state
        foreach ($allSorties as $currentSortie){
            $etatsRepository = $this->etatsRepository;

            /** @var \DateTime $dateFin */
            $dateFin = clone $currentSortie->getDateDebut();
            $dateFin->add(new \DateInterval('PT'.$currentSortie->getDuree().'M'));


            if (sizeof($currentSortie->getInscriptions()) >= $currentSortie->getNbInscriptionsmax() OR $currentDate > $currentSortie->getDateCloture())
            {
                //set cloturée
                $currentSortie->setEtat($etatsRepository->find(3));
            }

            if ($currentDate >= $currentSortie->getDateDebut() AND $currentDate < $dateFin)
            {
                //set activité en cours
                $currentSortie->setEtat($etatsRepository->find(4));
            }

            if ($currentDate > $dateFin)
            {
                //set passée
                $currentSortie->setEtat($etatsRepository->find(5));
            }
        }

    }
}