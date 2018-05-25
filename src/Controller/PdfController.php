<?php
//   On importe la classe Dompdf
namespace App\Controller;
use App\Entity\Commande;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//...
class PdfController extends AbstractController {
    /**
     * @Route("/pdf",name="pdf")
     *
     * @return Response
     */
    public function toPdfAction() {
        // On  crée une instance de Dompdf
        $dompdf = new Dompdf();
        //  On  ajoute le texte à afficher
        $dompdf->loadHtml('Hello world');
        // On fait générer le pdf  à Dompdf ...
        $dompdf->render();
        //  et on l'affiche dans un   objet Response
        return new Response($dompdf->stream("monPremierPdf"));
    }
    /**
     *
     * @Route("/pdf2/{num}",name="pdf2")
     *
     * @return Response
     */
    public function toPdfAction2($num, EntityManagerInterface $em) {
        $commandes = $em->getRepository(Commande::class)->findBy(['numCommande' => $num]);
        // On crée une  instance pour définir les options de notre fichier pdf
        $options = new Options();
        // Pour simplifier l'affichage des images, on autorise dompdf à utiliser
        // des  url pour les nom de  fichier
        $options->set('isRemoteEnabled', TRUE);
        // On crée une instance de dompdf avec  les options définies
        $dompdf = new Dompdf(['logOutputFile'=>'/home/d.p/tmp/log.html']);
        // On demande à Symfony de générer  le code html  correspondant à
        // notre template, et on stocke ce code dans une variable
        // Le fichier twig sera présent dans templates/pdf/
        $html = $this->renderView(
                'pdf/pdf.html.twig', array('commandes' => $commandes)
        );
        // On envoie le code html  à notre instance de dompdf
        $dompdf->loadHtml($html);
        // On demande à dompdf de générer le  pdf
        $dompdf->render();
        // On renvoie le flux (stream) du fichier pdf dans une  Response pour l'utilisateur
        return new Response($dompdf->stream("Commande n° " . $num));
    }
}