<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Panier;
use App\Entity\Categorie;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Description of LoginController
 *
 * @author d.poncet
 */
class ProduitController extends AbstractController {

    
    
    
    /**
     * @Route("/produit/{categ}",defaults={"categ"=null},name="produit")
     */
    public function apiTotoMethodeClassique($categ, EntityManagerInterface $em) {
        if ($categ) {
            $unProduit = $em->getRepository(Produit::class)->findByIdCategorie($categ);
        } else {
            $unProduit = $em->getRepository(Produit::class)->findAll();
        }
        $lesCategs = $em->getRepository(Categorie::class)->findAll();
        //getRepository(users::class) est l'equivalent de select * from users
        return $this->render("produit/produit.html.twig", array('produit' => $unProduit, 'lescategs' => $lesCategs));
        //$unToto[0] -> pour recup juste le premier objet
        //$unToto -> pour recup le tableau de tout les toto et dans le twig faut faire un for
    }
    
    
////affiche tout les produits sur la page produits
//    /**
//     * @Route("/produit", name="produit")
//     */
//    public function apiTotoMethodClassique(EntityManagerInterface $em) {
//        $produitTab = $em->getRepository(Produit::class)->findAll();
//        return$this->render("produit/produit.html.twig", array('produit' => $produitTab));
//    }

//Permet d'ajouter des produits dans le panier    
    /**
     * @Route("/ajoutPanier/{id}", name="ajoutPanier")
     */
    public function ajoutPanier($id, EntityManagerInterface $em) {
        $leProduit = $em->getRepository(Produit::class)->find($id);
        $stock = $leProduit->getStockProduit();
        
        $prix = $leProduit->getPrixProduit();
        
        //si le stock est superieur a 0 
        if ($stock > 0) {
            //on recupère le produit et l'user
            $user = $this->getUser()->getUsername();
            $panier = $em->getRepository(Panier::class)->findOneBy([
                'idProduit' => $id,
                'idUser' => $user]);
         //si le panier est diff de null 
            if ($panier != null) {
        //ajoute au panier        
                $qteA = $panier->getQte();
                $qteMtn = $qteA + 1;
                $panier->setQte($qteMtn);
                $prixPanier = $panier->getPrix();
                $prixTotal = $prixPanier + $prix;
                $panier->setPrix($prixTotal);
                
            } else {
                //creer un nv panier
                $panier = new Panier ();
                $panier->setQte(1);
                /// erreur ici  il faut definir un produit comme idUSer et pas un id 
                $panier->setIdProduit($leProduit);
                $panier->setPrix($leProduit->getPrixProduit());
                
                $panier->setIdUser($this->getUser());
                
            }
       
            $stockMtn = $stock - 1;
            $leProduit->setStockProduit($stockMtn);
          
           
            $em->persist($leProduit);
         $em->flush();
            //
            $em->persist($panier);
            $em->flush();
          
            return $this->redirectToRoute("produit");
            
        } else {
            
            return $this->redirectToRoute("produit");
        }
    }
    
    
    /**
     * @Route("/filtrecateg/{categ}",name="filtrecateg")
     */
    public function filtrecateg($categ, EntityManagerInterface $em) {
        $produits = $em->getRepository(Produit::class)->findByIdCategorie($categ);
        return $this->render("produit/produit.html.twig", array('produit' => $produits));
    }
}


