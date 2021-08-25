<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // création d'une variable $password contenant le plainPassword puis hash ARGON2I 
            $password = $form->get('plainPassword')->getData();
            $user->setPassword((password_hash($password, PASSWORD_ARGON2I))
            );
            /** @var UploadedFile $brochureFile */
            $imageFile = $form->get('avatar')->getData();
            if ($imageFile) {
                $newFilename = $user->getPseudo() . '.' . $imageFile->guessExtension();
                try {
                    $imageFile->move(
                        $this->getParameter('images_dir'),
                        $newFilename
                    );
                    $user->setAvatar($newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', $e->getMessage());
                }
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email
            $this->addFlash(
                'success',
                'Votre compte à été créé avec succès, vous pouvez maintenant vous connecter !'
            );

            return $this->redirectToRoute('home');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
