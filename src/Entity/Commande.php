<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity
 */
class Commande {
    /**
     * @var int
     *
     * @ORM\Column(name="num_commande", type="integer", nullable=false)
     * @ORM\Id
     */
    private $numCommande;
    
    /**
     * @var string
     *
     * @ORM\Column(name="id_user", type="string", nullable=false)
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="user")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="user_name", referencedColumnName="user_name")
     * })
     */
    private $userName;
    
    
    
    /**
     * @var int
     *
     * @ORM\Column(name="id_produit", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="produit")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="id_produit", referencedColumnName="id")
     * })
     */
    private $idProduit;
    
    
    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;
    
/**
     * @var int
     *
     * @ORM\Column(name="qte", type="integer", nullable=false)
     */
    private $qte;
    
    /**
     * @var date
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;
    
    function __construct() {
        
    }

    
    function getNumCommande() {
        return $this->numCommande;
    }

    function getUserName() {
        return $this->userName;
    }

    function getIdProduit() {
        return $this->idProduit;
    }

    function getPrix() {
        return $this->prix;
    }

    function getQte() {
        return $this->qte;
    }

    function getDate() {
        return $this->date;
    }

    function setNumCommande($numCommande) {
        $this->numCommande = $numCommande;
    }

    function setserName($userName) {
        $this->userName = $userName;
    }

    function setIdProduit($idProduit) {
        $this->idProduit = $idProduit;
    }

    function setPrix($prix) {
        $this->prix = $prix;
    }

    function setQte($qte) {
        $this->qte = $qte;
    }

    function setDate(date $date) {
        $this->date = $date;
    }


}
