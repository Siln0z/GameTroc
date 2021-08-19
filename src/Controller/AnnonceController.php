<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Annonce;
use App\Form\AnnonceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * @Route("/annonces")
 */
class AnnonceController extends AbstractController
{
    /**
     * @Route("/", name="annonces")
     */
    public function index()
    {
        $annonces = $this->getDoctrine()->getRepository(Annonce::class)->findAll();


        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonces,


        ]);
    }
    /**
     * @Route("/addannonce", name="add_annonce")
     */
    public function addAnnonce(Annonce $annonce = NULL, Request $request)
    {
        $annonceRepository = $this->getDoctrine()->getRepository(Annonce::class);

        $annonces = $annonceRepository->findBy([], ["id" => "ASC"]);
        if (!$annonce) {
            $annonce = new Annonce();
        }

        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $brochureFile */
            $imageFile = $form->get('photo')->getData();
            if ($imageFile) {
                $newFilename = $annonce->getTitre() . '.' . $imageFile->guessExtension();
                try {
                    $imageFile->move(
                        $this->getParameter('images_dir'),
                        $newFilename
                    );
                    $annonce->setPhoto($newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', $e->getMessage());
                }
            }
            $annonce = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($annonce);
            $entityManager->flush();

            return $this->redirectToRoute('annonces');
        }

        return $this->render('annonce/addAnnonce.html.twig', [
            'formAnnonce' => $form->createView(),
            'annonces'    => $annonces
        ]);
    }
    /**
     * @Route("/showannonce/{id}", name="show_annonce", methods="GET")
     */
    public function showAnnonce(Annonce $annonce): Response
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findAll($annonce->getUser());
        return $this->render("annonce/showAnnonce.html.twig", [
            'annonce' => $annonce,
            'user' => $user
            // "title"   => $sujet->getTitre(),
            // "reponses" => $reponses,
            // "commentaires" => $commentaires

        ]);
    }
}
