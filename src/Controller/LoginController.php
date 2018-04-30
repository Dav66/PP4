<?php
namespace App\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
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
class LoginController extends AbstractController{
    /**
     * @Route("/login", name="login")
     */
    
    public function login (AuthenticationUtils $auth){
        $erreur = $auth->getLastAuthenticationError();
        $lastUserName = $auth->getLastUsername();
        
        return $this->render('login/login.html.twig', array(
            'last_username'=> $lastUserName, 'error'=>$erreur
        ));
    }
}
