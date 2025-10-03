<?php

namespace App\Controller;

use App\Entity\Society;
use App\Form\SeveralSocietiesType;
use App\Form\SocietyType;
use App\Repository\SocietyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SocietyController extends AbstractController
{
    #[Route('/society', name: 'app_society')]
    public function index(Request $req, SocietyRepository $repo): Response
    {
        if(!$req->getSession()->get("is_authenticated"))
        {
            return $this->redirectToRoute("app_home");
        }

        $societies = $repo->findAll();
        
        return $this->render('society/index.html.twig',
        [
            'societies' => $societies,
        ]);
    }

    #[Route("/society/add", name: "add_society")]
    public function add(Request $req, EntityManagerInterface $em): Response
    {
        if(!$req->getSession()->get("is_authenticated"))
        {
            return $this->redirectToRoute("app_home");
        }

        $society = new Society();

        $form = $this->createForm(SocietyType::class, $society);
        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($society);
            $em->flush();

            $this->addFlash("success", "Société ajoutée");
            return $this->redirectToRoute("app_society");
        }

        return $this->render('society/add.html.twig',
        [
            'form' => $form,
        ]);
    }

    #[Route("/society/edit/{id}", name: "edit_society")]
    public function edit(Request $req, SocietyRepository $repo, int $id, EntityManagerInterface $em): Response
    {
        if(!$req->getSession()->get("is_authenticated"))
        {
            return $this->redirectToRoute("app_home");
        }

        $society = $repo->find($id);

        $form = $this->createForm(SocietyType::class, $society);
        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($society);
            $em->flush();

            $this->addFlash("success", "Société mise à jour");
            return $this->redirectToRoute("app_society");
        }

        return $this->render('society/edit.html.twig',
        [
            'form' => $form,
        ]);
    }

    #[Route("/society/add_several/{number}", name: "add_several_society")]
    public function addSeveral(Request $req, int $number, EntityManagerInterface $em): Response
    {
        if(!$req->getSession()->get("is_authenticated"))
        {
            return $this->redirectToRoute("app_home");
        }

        $societies = [];

        for($i = 0 ; $i < $number ; $i++)
        {
            $societies[] = new Society();
        }

        $form = $this->createForm(SeveralSocietiesType::class, ["societies" => $societies]);
        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid())
        {
            foreach($societies as $society)
            {
                $em->persist($society);
            }
            
            $em->flush();

            $this->addFlash("success", $number . " sociétés ajoutées avec succès");
            return $this->redirectToRoute("app_society");
        }

        return $this->render('society/add_several.html.twig',
        [
            'form' => $form,
        ]);
    }

    #[Route("/society/view/{id}", name: "view_society")]
    public function view(Request $req, SocietyRepository $repo, int $id): Response
    {
        if(!$req->getSession()->get("is_authenticated"))
        {
            return $this->redirectToRoute("app_home");
        }

        $society = $repo->find($id);

        return $this->render('society/view.html.twig',
        [
            'society' => $society,
        ]);
    }

    #[Route("/society/delete/{id}", name: "delete_society")]
    public function delete(Request $req,SocietyRepository $repo, int $id, EntityManagerInterface $em): Response
    {
        if(!$req->getSession()->get("is_authenticated"))
        {
            return $this->redirectToRoute("app_home");
        }

        $society = $repo->find($id);

        $em->remove($society);
        $em->flush();

        $this->addFlash("success", "Société supprimée");

        return $this->redirectToRoute("app_society");
    }
}
