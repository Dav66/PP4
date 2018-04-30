<?php

namespace App\Controller;

use App\Entity\Panier;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Description of PanierController
 *
 * @author d.poncet
 */
class PanierController extends AbstractController {

    /**
     * @Route("/panier", name="panier")
     */
    public function panier(\Doctrine\ORM\EntityManagerInterface $em) {
        
        
        
        $user = $this->getUser()->getUsername();
        $panier = $em->getRepository(Panier::class)->findBy(['idUser' => $user]);
        if ($panier == null) {
            $vide = "1==1";
            return $this->render('panier/panier.html.twig', ['panier' => $panier, 'vide' => $vide,]);
        }
        $vide = "";
        return $this->render('panier/panier.html.twig', ['panier' => $panier, 'vide' => $vide]);
    }

}
