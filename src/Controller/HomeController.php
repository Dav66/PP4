<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HomeController
 *
 * @author d.poncet
 */
class HomeController extends AbstractController{
  /**
   * @Route("/",name="home")
   * @return Response
   */

public function indexController(){
    //return new Response("Exemple d'exploitation");
    //ou on crée "rend" une twig
    
    return $this->render('home/index.html.twig');
    
    
}
    /**
     * @Route("/visiteur",name="visiteur")
     * @return Response
     */

public function visisteurController(){
    return $this->render('visiteur/visiteur.html.twig');
    
}

/**
     * @Route("/perso",name="perso")
     * @return Response
     */

public function persoController(){
    return $this->render('perso/perso.html.twig');
}

}
