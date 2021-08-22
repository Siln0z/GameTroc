<?php

namespace App\Controller;

use App\Entity\Annonce;
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
    public function index(): Response
    {
        $annonces = $this->getDoctrine()->getRepository(Annonce::class)->findAll();
        $annonces = array_slice($annonces, 2);
        return $this->render('home/index.html.twig', [
            'annonces' => $annonces
        ]);
    }
}
