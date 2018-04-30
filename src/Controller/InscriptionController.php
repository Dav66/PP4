<?php

namespace App\Controller;

 use Symfony\Component\Routing\Annotation\Route;
 use Symfony\Component\HttpFoundation\Request;
 use App\Entity\User;
/**
 * Description of InscriptionController
 *
 * @author d.poncet
 */
class InscriptionController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController{
    /**
     * 
     * @Route("/Ajouter",name="ajouter")
     */
    
    public function Ajouter (\Doctrine\ORM\EntityManagerInterface $em, Request $request) {
        $unUser = new User ();
        $form = $this->createFormBuilder($unUser)
                ->add('userName',  \Symfony\Component\Form\Extension\Core\Type\TextType::class, ["label"=>"Identifiant"])
                ->add('password',  \Symfony\Component\Form\Extension\Core\Type\TextType::class, ["label"=>"Mot de passe"])
                ->add('email')
                ->add ('Enregistrer', \Symfony\Component\Form\Extension\Core\Type\SubmitType::class, array('label' => "Création de l'employé", "attr" => array("class"=> "btn-success")))
                ->getForm()
                ;
        $form->handleRequest ($request);
        if ($form->isSubmitted()&&$form->isValid()){
           $unUser->setIsActive(1);
           $unUser->setRole("ROLE_USER").
            $em->persist($unUser);
            $em->flush();
            return $this->redirectToRoute("home");
        }
        return$this->render("Inscription/inscription.html.twig", array('form'=> $form->createView()));
    }        
}