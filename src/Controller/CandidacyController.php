<?php

namespace App\Controller;

use App\Entity\Candidacy;
use App\Form\CandidacyType;
use App\Form\SeveralCandidaciesType;
use App\Repository\CandidacyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CandidacyController extends AbstractController
{
    #[Route('/candidacy', name: 'app_candidacy')]
    public function index(CandidacyRepository $repo): Response
    {
        $candidacies = $repo->findAll();
        
        return $this->render('candidacy/index.html.twig',
        [
            'candidacies' => $candidacies
        ]);
    }

    #[Route("/candidacy/add", name: "add_candidacy")]
    public function add(Request $req, EntityManagerInterface $em): Response
    {
        $candidacy = new Candidacy();

        $candidacy->setAppliedAt(new \DateTime());

        $form = $this->createForm(CandidacyType::class, $candidacy);
        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($candidacy);
            $em->flush();

            $this->addFlash("success", "Candidature ajoutée");
            return $this->redirectToRoute("app_candidacy");
        }
        
        return $this->render('candidacy/add.html.twig',
        [
            'form' => $form
        ]);
    }

    #[Route("/candidacy/add_several/{number}", name: "add_several_candidacy")]
    public function addSeveral(Request $req, int $number, EntityManagerInterface $em): Response
    {
        $candidacies = [];

        for($i = 0 ; $i < $number ; $i++)
        {
            $candidacies[] = new Candidacy();
        }

        $form = $this->createForm(SeveralCandidaciesType::class, ["candidacies" => $candidacies]);
        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid())
        {
            foreach($candidacies as $candidacy)
            {
                $em->persist($candidacy);
            }
            
            $em->flush();

            $this->addFlash("success", $number . " candidatures ajoutées avec succès");
            return $this->redirectToRoute("app_candidacy");
        }

        return $this->render('candidacy/add_several.html.twig',
        [
            'form' => $form,
        ]);
    }

    #[Route("/candidacy/edit/{id}", name: "edit_candidacy")]
    public function edit(Request $req, CandidacyRepository $repo, int $id, EntityManagerInterface $em): Response
    {
        $candidacy = $repo->find($id);

        $form = $this->createForm(CandidacyType::class, $candidacy);
        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($candidacy);
            $em->flush();

            $this->addFlash("success", "Candidature mise à jour");
            return $this->redirectToRoute("app_candidacy");
        }
        
        return $this->render('candidacy/edit.html.twig',
        [
            'form' => $form
        ]);
    }

    #[Route("/candidacy/view/{id}", name: "view_candidacy")]
    public function view(CandidacyRepository $repo, int $id): Response
    {
        $candidacy = $repo->find($id);
        
        return $this->render('candidacy/view.html.twig',
        [
            'candidacy' => $candidacy
        ]);
    }

    #[Route("/candidacy/delete/{id}", name: "delete_candidacy")]
    public function delete(CandidacyRepository $repo, int $id, EntityManagerInterface $em): Response
    {
        $candidacy = $repo->find($id);

        $em->remove($candidacy);
        $em->flush();

        $this->addFlash("success", "Candidature supprimée");
        
        return $this->redirectToRoute("app_candidacy");
    }
}
