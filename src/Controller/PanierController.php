<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
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
    
    
    
    //ajouter des produits dans le panier    
    /**
     * @Route("/ajoutExemplaireProdPanier/{id}", name="ajoutExemplaireProdPanier")
     */
    public function ajoutExemplaireProdPanier($id, EntityManagerInterface $em) {
        $leProduit = $em->getRepository(Produit::class)->find($id);
        $stock = $leProduit->getStockProduit();
        $prix = $leProduit->getPrixProduit();

        //si le stock est superieur a 0 
        if ($stock > 0) {
            //on recupère le produit et l'utilisateur
            $user = $this->getUser()->getUsername();
            $panier = $em->getRepository(Panier::class)->findOneBy([
                'idProduit' => $id,
                'idUser' => $user,
                    ]);
            
            //si le panier n'est pas vide 
            if ($panier != null) {
                //ajoute au panier        
                $qte = $panier->getQte();
                $qtePlus = $qte + 1;
                $panier->setQte($qtePlus);
                $prixPanier = $panier->getPrix();
                $prixTotal = $prixPanier + $prix;
                $panier->setPrix($prixTotal);
            } else {
                
                //creer un nv panier
                $panier = new Panier ();
                $panier->setQte(1);
                $panier->setIdProduit($leProduit);
                $panier->setPrix($leProduit->getPrixProduit());
                $panier->setIdUser($this->getUser());
                
            }
            //on enleve un exemplaire du stock du produit
            $stockMoins = $stock - 1;
            $leProduit->setStockProduit($stockMoins);

            $em->persist($leProduit);
            $em->flush();
            $em->persist($panier);
            $em->flush();

            return $this->redirectToRoute("produit");
        } else {

            return $this->redirectToRoute("produit");
        }
    }
    
    
    
    

 //   /**
 //    * @Route("/retireExemplaireProdPanier/{id}",name="retireExemplaireProdPanier")
//    */
//    public function retireExemplaireProdPanier($id, EntityManagerInterface $em) {
//       $user = $this->getUser()->getUsername();
//       $leProduit = $em->getRepository(Panier::class)->findOneBy([
//            'idProduit' => $id,
//            'idUser' => $user
//            
//        ]);
//        $qte = $leProduit->getQte();
//        $prixTotal = $leProduit->getPrix();
//        $idproduit = $leProduit->getIdProduit();
////        
//        $prodBazar = $em->getRepository(Produit::class)->findOneBy([
//            'id' => $idproduit,
//        ]);
//  
//        $qteMoins = $qte - 1;
//        $stockProduit = $prodBazar->getStockProduit();
//        $stockProduitPlus = $stockProduit + 1;
//        if ($qte == 1) {
//            $em->remove($leProduit);
//            $em->flush();
//            return $this->redirectToRoute("panier");
//        }
//        $prixProduit = $prodBazar->getPrixProduit();
//        $prixPanier = $prixTotal - $prixProduit;
//        $leProduit->setPrix($prixPanier);
//        $leProduit->setQte($qteMoins);
//        $prodBazar->setStock($stockProduitPlus);
//        $em->persist($leProduit);
//        $em->persist($prodBazar);
//        $em->flush();
//            
//        return $this->redirectToRoute("panier");
//  }
//       
//                
//               
//    /**
//     * @Route("/suppTupleProdPanier/{id}",name="suppTupleProdPanier")
//     */
//     public function suppTupleProdPanier($id, EntityManagerInterface $em) {
//        $produit = $em->getRepository(Panier::class)->find($id);
//        $qte = $produit->getQuantite();
//        $nomProduit = $produit->getIdProduit()->getNomProduit();
//        $bazar = $em->getRepository(Produits::class)->find($nomProduit);
//        $stock = $bazar->getStockProduit();
//        $stockPlus = $stock + $qte;
//        $bazar->setStockProduit($stockPlus);
//        $em->persist($bazar);
//        $em->remove($produit);
//        $em->flush();
//
//        return $this->redirectToRoute("panier");
//    }
    
//   /**
//    ** @Route("/suppTupleProdPanier/{id}",name="suppTupleProdPanier")
//     */
////     public function viderPanier($id, EntityManagerInterface $em) {
//        $panier=$em->getRepository(Panier::class)->find($id);
//        
//     }
    
//    /**
//     * @route("/supprPanier/{id}",name="supprPanier")
//     * @return Response
//     */
    
//    public function supprProduitPanier($id, EntityManagerInterface $em) {
//        $actuUser = $this->getUser()->getUsername();
//        $panier = $this->getDoctrine()->getRepository(Panier::class)->findOneBy([
//            'idProduit' => $id,
//            'idUser' => $actuUser
//        ]);
//        $em->remove($panier);
//        $sql = "DELETE FROM `panier` WHERE id_produit = :id AND id_user = :user";
//        $idProduit = $panier->getIdProduit()->getId();
//        $stmt = $em->getConnection()->prepare($sql);
//        $stmt->execute(['id' => $idProduit, 'user' => $actuUser]);
//        $em->persist($panier);
//        $em->flush();
//        return $this->redirectToRoute("panier");
//    }


}
