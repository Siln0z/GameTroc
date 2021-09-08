<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Annonce;
use App\Entity\Reponse;
use App\Form\AnnonceType;
use App\Form\ReponseType;
use Knp\Component\Pager\PaginatorInterface;
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
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $donneesAnnonces = $this->getDoctrine()->getRepository(Annonce::class)->findBy([], ['dateCreation' => 'DESC']);
        $annonces = $paginator->paginate(
            $donneesAnnonces, //On passe les données
            $request->query->getInt('page', 1), //Numéro de la page en cours, 1 par default
            6 //Nb d'éléments par page
        );
        $nbAnnonces = $this->getDoctrine()->getRepository(Annonce::class)->countAnnonces();
        $reponses = $this->getDoctrine()->getRepository(Annonce::class)->findBy([], ['dateCreation' => 'DESC']);

        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonces,
            'reponses' => $reponses,
            'nbAnnonces' => $nbAnnonces

        ]);
    }
    /**
     * @Route("/addannonce", name="add_annonce")
     * @Route("/{id}/editannonce", name="edit_annonce")
     */
    public function addAnnonce(Annonce $annonce = NULL, Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
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
            $annonce->setUser($this->getUser());
            $annonce = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($annonce);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Votre annonce a été postée avec succès!'
            );

            return $this->redirectToRoute('annonces');
        }

        return $this->render('annonce/addAnnonce.html.twig', [
            'formAnnonce' => $form->createView(),
            'annonces'    => $annonces
        ]);
    }
    /**
     * @Route("/addreponse/{id}", name="add_reponse")
     * 
     */
    public function addReponse(Annonce $annonce, Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $reponse = new Reponse();

        $form = $this->createForm(ReponseType::class, $reponse);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $reponse->setUser($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $annonce->addReponse($reponse);

            $entityManager->persist($reponse);

            $entityManager->flush();

            $this->addFlash(
                'success',
                'La réponse à bien été ajoutée!'
            );

            return $this->redirectToRoute('show_annonce', ['id' => $annonce->getId()]);
        }
        return $this->render('annonce/addreponse.html.twig', [
            'formReponse' => $form->createView(),
            'reponse'    => $reponse
        ]);
    }
    /**
     * @Route("/showannonce/{id}", name="show_annonce", methods="GET")
     */
    public function showAnnonce(Annonce $annonce, Request $request, PaginatorInterface $paginator): Response
    {
        $user = $annonce->getUser();

        $donneesReponses = $this->getDoctrine()->getRepository(Reponse::class)->findBy(['annonce' => $annonce->getId()]);
        $reponses = $paginator->paginate(
            $donneesReponses, //On passe les données
            $request->query->getInt('page', 1), //Numéro de la page en cours, 1 par default
            6 //Nb d'éléments par page
        );

        return $this->render("annonce/showAnnonce.html.twig", [
            'annonce' => $annonce,
            'user' => $user,
            'reponses' => $reponses,
        ]);
    }
    /**
     * @Route("/showannonce/supprannonce/{id}",name="suppr_annonce", methods="GET")  
     */
    public function removeAnnonce(Annonce $annonce = NULL)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $suppr = $this->getDoctrine()->getManager();
        $suppr->remove($annonce);
        $suppr->flush();

        $this->addFlash(
            'warning',
            'cette annonce à bien été supprimée !'
        );

        return $this->redirectToRoute('annonces');
    }
    /**
     * @Route("/showannonce/supprreponse/{id}",name="suppr_reponse", methods="GET")  
     */
    public function removeReponse(Reponse $reponse = NULL)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $suppr = $this->getDoctrine()->getManager();
        $suppr->remove($reponse);
        $suppr->flush();

        $this->addFlash(
            'warning',
            'La réponse à bien été supprimée!'
        );

        return $this->redirectToRoute('annonces');
    }
}
