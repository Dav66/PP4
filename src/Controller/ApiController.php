<?php

namespace App\Controller;

use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use function dump;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LoginController
 *
 * @author d.poncet
 */
class ApiController extends AbstractController {

    /**
     * @Route("/produitclassique/{id}", name="un_produit_clas")
     */
    public function apiTotoMethodClassique($id, EntityManagerInterface $em) {
        $unProduit = $em->getRepository(Produit::class)->findById($id);
        //appel au service de sérialisation
        //l'objet $unUser sera transformé en json 
        $serializer = $this->get('serializer');
        $data = $serializer->serialize($unProduit[0], 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'applcation/json');
        $response->headers->set('Ok', 'oui');
        return $response;
    }

    /**
     * @Route("/produitautomatique/{id}", name="un_user_auto")
     */
    public function apiTotoMethodAutomatique(Produit $unProduit = null) {
        if ($unProduit === null) {
            $response = new Response($unProduit);
            $response->headers->set('Ok', 'oui');
            $response->setStatusCode(404);
            return $response;
        }

        $serializer = $this->get('serializer');
        $data = $serializer->serialize($unProduit, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'applcation/json');
        $response->headers->set('Ok', 'oui');
        return $response;
    }

    /**
     * @Route("/produitAll", name="produit_all")
     */
    public function apiTotoMethodAll(EntityManagerInterface $em) {
        $unProduit = $em->getRepository(Produit::class)->findAll();
        //appel au service de sérialisation
        //l'objet $unUser sera transformé en json 
        $serializer = $this->get('serializer');
        $data = $serializer->serialize($unProduit, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'applcation/json');
        $response->headers->set('Ok', 'oui');
        return $response;
    }
    
    /**
     * @Route("/ajouttoto/", name="ajout_toto",methods="post")
     */
    public function ajoutToto(Request $request, EntityManagerInterface $em) {
        
        $serializer = $this->get('serializer');
        $unProduit = $serializer->deserialize($request->getContent(),Produit::class, 'json');
        $em->persist($unProduit);
        $em->flush();
        
        $response = new Response("L'ajout est réalisé !");
        $response->headers->set('Content-Type', 'applcation/text');
        $response->headers->set('Ok', 'oui');
        return $response;
    }
}
