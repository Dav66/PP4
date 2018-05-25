<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Panier;
use App\Entity\Produit;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of PanierController
 *
 * @author d.poncet
 */
class PanierController extends AbstractController {

    /**
     * @Route("/panier", name="panier")
     */
    public function panier(EntityManagerInterface $em) {

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
// Moins un exemplaire du produit selectionner dans le panier
    /**
     * @Route("/moinsExemplaireProdPanier/{id}",name="moinsExemplaireProdPanier")
     */
    public function moinsExemplaireProdPanier($id, EntityManagerInterface $em) {
//       $user = $this->getUser()->getUsername();
        $leProduit = $em->getRepository(Panier::class)->find($id);

        $qte = $leProduit->getQte();
        $prixTotal = $leProduit->getPrix();
        $idproduit = $leProduit->getIdProduit();
//        
        $prodBazar = $em->getRepository(Produit::class)->findOneBy([
            'id' => $idproduit,
        ]);

        $qteMoins = $qte - 1;
        $stockProduit = $prodBazar->getStockProduit();
        $stockProduitPlus = $stockProduit + 1;
        if ($qte == 1) {
            $em->remove($leProduit);
            $em->flush();
            return $this->redirectToRoute("panier");
        }
        $prixProduit = $prodBazar->getPrixProduit();
        $prixPanier = $prixTotal - $prixProduit;

        $leProduit->setPrix($prixPanier);
        $leProduit->setQte($qteMoins);
        $prodBazar->setStockProduit($stockProduitPlus);
        $em->persist($leProduit);
        $em->persist($prodBazar);
        $em->flush();

        return $this->redirectToRoute("panier");
    }


    // Plus un exemplaire du produit selectionner dans le panier
    /**
     * @Route("/plusExemplaireProdPanier/{id}",name="plusExemplaireProdPanier")
     */
    public function plusExemplaireProdPanier($id, EntityManagerInterface $em) {
//       $user = $this->getUser()->getUsername();
        $leProduit = $em->getRepository(Panier::class)->find($id);

        $qte = $leProduit->getQte();
        $prixTotal = $leProduit->getPrix();
        $idproduit = $leProduit->getIdProduit();
//        
        $prodBazar = $em->getRepository(Produit::class)->findOneBy([
            'id' => $idproduit,
        ]);

        $qteMoins = $qte + 1;
        $stockProduit = $prodBazar->getStockProduit();
        $stockProduitPlus = $stockProduit - 1;

        $prixProduit = $prodBazar->getPrixProduit();
        $prixPanier = $prixTotal + $prixProduit;

        $leProduit->setPrix($prixPanier);
        $leProduit->setQte($qteMoins);
        $prodBazar->setStockProduit($stockProduitPlus);
        $em->persist($leProduit);
        $em->persist($prodBazar);
        $em->flush();

        return $this->redirectToRoute("panier");
    }

     //Supprime tout les exemplaires du produit selectionnés dans le panier         
    /**
     * @Route("/suppTupleProdPanier/{id}",name="suppTupleProdPanier")
     */
    public function suppTupleProdPanier($id, EntityManagerInterface $em) {
        $leproduit = $em->getRepository(Panier::class)->find($id);
        $qte = $leproduit->getQte();
        $idProduit = $leproduit->getIdProduit();


        $bazar = $em->getRepository(Produit::class)->find($idProduit);
        $stock = $bazar->getStockProduit();
        $stockPlus = $stock + $qte;
        $bazar->setStockProduit($stockPlus);
        $em->persist($bazar);
        $em->remove($leproduit);
        $em->flush();

        return $this->redirectToRoute("panier");
    }
 
    
    /**
     * @route("/supprPanier/{id}",name="supprPanier")
     * @return Response
     */
    public function supprProduitPanier($id, EntityManagerInterface $em) {
        $actuUser = $this->getUser()->getUsername();
        $panier = $this->getDoctrine()->getRepository(Panier::class)->findOneBy([
            'idProduit' => $id,
            'idUser' => $actuUser
        ]);
        $em->remove($panier);
        $sql = "DELETE FROM `panier` WHERE id_produit = :id AND id_user = :user";
        $idProduit = $panier->getIdProduit();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute(['id' => $idProduit, 'user' => $actuUser]);
        $em->persist($panier);
        $em->flush();
        return $this->redirectToRoute("panier");
    }
    
    
    
    
    /**
     * @Route("/validPanier",name="validPanier")
     */
    public function validPanier(EntityManagerInterface $em) {
        $user = $this->getUser()->getUsername();
        $produits = $em->getRepository(Panier::class)->findBy(['idUser' => $user]);
   
        $numCom = "";
        for ($i = 0; $i < 7; $i++) {
            $j = rand(1, 3);
            if ($j == 1) {
                $numCom = $numCom . chr(rand(48, 57));
            }
            if ($j == 2) {
                $numCom = $numCom . chr(rand(65, 90));
            }
            if ($j == 3) {
                $numCom = $numCom . chr(rand(97, 122));
            }
        }
        if (isset($produits)) {
            foreach ($produits as $unProduit) {
                $commande = new Commande();
                $commande->setNumCommande($numCom);
                $commande->setIdProduit($unProduit->getIdProduit());
                $commande->setUserName($this->getUser());
                $commande->setDate((new DateTime('now')));
                $commande->setQte($unProduit->getQte());
                $commande->setEstValid(0);
                $commande->setPrix($unProduit->getPrix());
                $em->persist($commande);
                $em->remove($unProduit);
            }
        }
        $em->flush();
        return $this->redirectToRoute("commande");
    }

}
