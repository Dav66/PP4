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
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="num_commande", type="integer", nullable=false)
     */
    private $numCommande;
    
    /**
     * @var user
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="user_name", referencedColumnName="user_name")
     * })
     */
    private $userName;
    
    
    
    /**
     * @var produit
     * @ORM\ManyToOne(targetEntity="Produit")
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
    
 /**
     * @var bool
     *
     * @ORM\Column(name="est_valid", type="boolean", nullable=false)
     */
    public $estValid;   
    
    function __construct() {
        
    }

    function getId() {
        return $this->id;
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

    function getEstValid() {
        return $this->estValid;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNumCommande($numCommande) {
        $this->numCommande = $numCommande;
    }

    function setUserName(User $userName) {
        $this->userName = $userName;
    }

    function setIdProduit(Produit $idProduit) {
        $this->idProduit = $idProduit;
    }

    function setPrix($prix) {
        $this->prix = $prix;
    }

    function setQte($qte) {
        $this->qte = $qte;
    }

    function setDate($date) {
        $this->date = $date;
    }

    function setEstValid($estValid) {
        $this->estValid = $estValid;
    }


}
