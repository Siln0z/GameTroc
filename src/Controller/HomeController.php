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
        $annonces = $annonceRepository->findTroisDernieresAnnonces();
        $nbAnnonces = $this->getDoctrine()->getRepository(Annonce::class)->countAnnonces();

        return $this->render('home/index.html.twig', [
            'annonces' => $annonces,
            'nbAnnonces' => $nbAnnonces
        ]);
    }
    /**
     * @Route("/rules", name="rules")
     */
    public function rules()
    {

        return $this->render('regles.html.twig', []);
    }
}
