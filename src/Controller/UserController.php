<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user")
     */
    public function index(): Response
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('user/index.html.twig', [
            'user' => $user
        ]);
    }
    // /**
    //  * @Route("/edituser", name="edit_user")
    //  */
    // public function editUser(Request $request, ObjectManager $manager): Response
    // {
    //     $user = $this->getUser();

    //     $form = $this->createForm(RegistrationFormType::class, $user);

    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         //dump($form->getData());exit;
    //         if ($user->getAvatar() !== null) {
    //             $file = $user->getAvatar();
    //             $user->setAvatarFile($file);
    //         }

    //         $manager->persist($user);
    //         $manager->flush();

    //         return $this->redirectToRoute('user');
    //     }

    //     return $this->render('user/profileEdit.html.twig', [
    //         'form' => $form->createView()
    //     ]);
    // }

    /**
     * @Route("/ban/{id}", name="ban")
     */
    public function banUser(User $user)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $em = $this->getDoctrine()->getManager();

        $user->switchBan();
        $em->flush();

        if ($user->getBanni() == 0) {
            $this->addFlash('success', "Utilisateur débloqué !");
        } else {
            $this->addFlash('error', "Utilisateur bloqué !");
        }

        return $this->redirectToRoute('admin_users');
    }


    public function showProfile()
    {
    }
}
