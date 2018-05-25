<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Panier;
use App\Entity\Produits;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/**
 * Description of CommandeController
 *
 * @author d.poncet
 */
class CommandeController extends AbstractController {
    /**
     * @Route("/commande", name="commande")
     */
    public function commande(EntityManagerInterface $em) {
        
        
        
        $user = $this->getUser()->getUsername();
        $commande = $em->getRepository(Commande::class)->findBy(['userName' => $user]);
        if ($commande == null) {
            $vide = "1==1";
            return $this->render('commande/commande.html.twig', ['commande' => $commande, 'vide' => $vide,]);
        }
        $vide = "";
        return $this->render('commande/commande.html.twig', ['commande' => $commande, 'vide' => $vide]);
    }
    
    
}
