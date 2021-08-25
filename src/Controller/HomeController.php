<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Repository\AnnonceRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(AnnonceRepository $annonceRepository): Response
    {
        // $annonces = $this->getDoctrine()->getManager()->createQueryBuilder(
        //     'SELECT a 
        //     FROM App\Entity\Annonce a 
        //     ORDER BY a.dateCreation 
        //     DESC'
        // )->setMaxResults(3)->getResult();

        $annonces = $annonceRepository->findTroisDernieresAnnonces();

        return $this->render('home/index.html.twig', [
            'annonces' => $annonces
        ]);
    }
}
