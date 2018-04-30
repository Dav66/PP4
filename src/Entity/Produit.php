<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity
 */
class Produit {

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
     * @ORM\Column(name="nom_produit", type="string", length=255, nullable=false)
     */
    private $nomProduit;

    /**
     * @var string
     *
     * @ORM\Column(name="photo_produit", type="string", length=255, nullable=false)
     */
    private $photoProduit;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_produit", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixProduit;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=255, nullable=false)
     */
    private $text;
    /**
     * @var int
     *
     * @ORM\Column(name="stock_produit", type="integer", nullable=false)
     */
    private $stockProduit;
    
    /**
     * @var categorie
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="id_categorie", referencedColumnName="id_categorie")
     * })
     */
    private $idCategorie;
    
    function __construct() {
        
    }
    
    function getId() {
        return $this->id;
    }

    function getNomProduit() {
        return $this->nomProduit;
    }

    function getPhotoProduit() {
        return $this->photoProduit;
    }

    function getPrixProduit() {
        return $this->prixProduit;
    }

    function getText() {
        return $this->text;
    }

    function getStockProduit() {
        return $this->stockProduit;
    }

    function getIdCategorie() {
        return $this->idCategorie;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNomProduit($nomProduit) {
        $this->nomProduit = $nomProduit;
    }

    function setPhotoProduit($photoProduit) {
        $this->photoProduit = $photoProduit;
    }

    function setPrixProduit($prixProduit) {
        $this->prixProduit = $prixProduit;
    }

    function setText($text) {
        $this->text = $text;
    }

    function setStockProduit($stockProduit) {
        $this->stockProduit = $stockProduit;
    }

    function setIdCategorie(categorie $idCategorie) {
        $this->idCategorie = $idCategorie;
    }


}
