<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity
 */
class Categorie {

    /**
     * @var int
     *
     * @ORM\Column(name="id_categorie", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCategorie;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_categorie", type="string", length=255, nullable=false)
     */
    private $nomCategorie;
    //put your code here
    
    function __construct() {
        
    }
    
    
    function getIdCategorie() {
        return $this->idCategorie;
    }

    function getNomCategorie() {
        return $this->nomCategorie;
    }

    function setIdCategorie($idCategorie) {
        $this->idCategorie = $idCategorie;
    }

    function setNomCategorie($nomCategorie) {
        $this->nomCategorie = $nomCategorie;
    }



  
}
