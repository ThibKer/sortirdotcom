<?php
namespace App\Util;

use App\Entity\Sortie;

class Tri {

    /**
     * @param Sortie $s1
     * @param Sortie $s2
     * Fonction utile pour le tri des sorties
     */
    public function triSorties(Sortie $s1, Sortie $s2){
        if($s1->getEtat()->getId() == $s2->getEtat()->getId()){
            return 0;
        } elseif ($s1->getEtat()->getId() > $s2->getEtat()->getId()){
            return 1;
        } else {
            return -1;
        }
    }
}