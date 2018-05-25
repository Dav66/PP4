<?php 
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Panier
 *
 * @ORM\Table(name="panier")
 * @ORM\Entity
 */
class Panier {
    
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id; 

    
    /**

     *
    @var produit

     * 
     * @ORM\ManyToOne(targetEntity="Produit")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="id_produit", referencedColumnName="id")
     * })
     */
    private $idProduit;
    
    /**

     *
     *      @var user

     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="id_user", referencedColumnName="user_name")
     * })
     */    
    private $idUser;
    
/**
     * @var int
     *
     * @ORM\Column(name="qte", type="integer", nullable=false)
     */
    private $qte;
    
    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", nullable=false)
     */
    private $prix;
    
    function __construct() {
        
    }
    function getId() {
        return $this->id;
    }
    
    function getIdProduit() {
        return $this->idProduit;
    }

    function getIdUser() {
        return $this->idUser;
    }

    function getQte() {
        return $this->qte;
    }
    
        function getPrix() {
        return $this->prix;
    }
    function setId($id) {
        $this->id = $id;
    }

    function setIdProduit($idProduit) {
        $this->idProduit = $idProduit;
    }

    function setIdUser($idUser) {
        $this->idUser = $idUser;
    }

    function setQte($qte) {
        $this->qte = $qte;
    }


    function setPrix($prix) {
        $this->prix = $prix;
    }



    
    

    



}
