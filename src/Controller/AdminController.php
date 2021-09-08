<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Reponse;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin")
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    /**
     * @Route("/adminusers", name="admin_users")
     */
    public function listeUser(UserRepository $userRepository)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');


        $nbAnnoncesParUser = $this->getDoctrine()->getRepository(Annonce::class)->countAnnoncesByUser();
        // $nbReponsesParUser = $this->getDoctrine()->getRepository(Reponse::class)->countReponsesByUser();
        // dd($nbReponsesParUser);

        return $this->render('admin/adminUsers.html.twig', [
            'nbAnnoncesParUser' => $nbAnnoncesParUser,

        ]);
    }
}
