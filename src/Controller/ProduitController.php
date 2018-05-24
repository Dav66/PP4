<?php

namespace App\Controller;

use App\Entity\Produit;
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
        //Si une categorie est selection alors on affiche les produits de cette categorie
        if ($categ) {
            $unProduit = $em->getRepository(Produit::class)->findByIdCategorie($categ);
            //sinon on affiche tout les produit
        } else {
            $unProduit = $em->getRepository(Produit::class)->findAll();
        }
        $lesCategs = $em->getRepository(Categorie::class)->findAll();
        //getRepository(users::class) est l'equivalent de select * from users
        return $this->render("produit/produit.html.twig", array('produit' => $unProduit, 'lescategs' => $lesCategs));
        //$unToto[0] -> pour recup juste le premier objet
        //$unToto -> pour recup le tableau de tout les toto et dans le twig faut faire un for
    }
/**
         * @Route("/filtrecateg/{categ}",name="filtrecateg")
         */
        public function filtrecateg($categ, EntityManagerInterface $em) {
            $produits = $em->getRepository(Produit::class)->findByIdCategorie($categ);
            return $this->render("produit/produit.html.twig", array('produit' => $produits));
        }

//    /**
//     * @Route("/retireExemplaireProd/{id}",name="retireExemplaireProd")
//     */
//    public function retireExemplaireProd($id, EntityManagerInterface $em) {
//        $leProduit = $em->getRepository(Panier::class)->find($id);
//        $stockac = $leProduit->getStockProduit();
//        $prix = $leProduit->getPrixProduit();
//        $idproduit = $leProduit->getIdProduit();
//        
//        $prodBazar = $em->getRepository(Produit::class)->findOneBy([
//            'id' => $idproduit,
//        ]);
//        $stockmtn = $stockac - 1;
//        $stockacbazar = $prodBazar->getStockProduit();
//        $stockmtnbazar = $stockacbazar + 1;
//        if ($stockac == 1) {
//            $em->remove($leProduit);
//            $em->flush();
//            return $this->redirectToRoute("panier");
//        }
//        $prixprod = $prodBazar->getPrix();
//        $prixpanier = $prix - $prixprod;
//        $leProduit->setPrix($prixpanier);
//        $leProduit->setQte($stockmtn);
//        $prodBazar->setStock($stockmtnbazar);
//        $em->persist($leProduit);
//        $em->persist($prodBazar);
//        $em->flush();
////            return $this->render("boutique/css.html.twig", array('untoto' => $unToto));
//        return $this->redirectToRoute("panier");
//    }
//        
//        
        
    
        

    }
    