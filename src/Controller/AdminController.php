<?php

namespace App\Controller;

use App\Entity\User;
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
    public function listeUser(User $users)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('admin/adminUsers.html.twig', [
            'users' => $users,
        ]);
    }
}
