<?php

namespace App\Controller;

use App\Form\LoginFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $req): Response
    {
        if(!$req->getSession()->get("is_authenticated"))
        {
            $form = $this->createForm(LoginFormType::class);
            $form->handleRequest($req);

            if($form->isSubmitted() && $form->isValid())
            {
                if(!password_verify($form->getData()["password"], $_ENV["APP_SECRET_PASSWORD"]))
                {
                    $this->addFlash("error", "Mauvais mot de passe");
                }

                else
                {
                    $req->getSession()->set("is_authenticated", true);
                    return $this->redirectToRoute("app_home");
                }
            }

            return $this->render('home/login.html.twig', ["form" => $form]);
        }
        
        return $this->render('home/index.html.twig');
    }

    #[Route("/logout", name: "app_logout")]
    public function logout(Request $req): Response
    {
        $req->getSession()->set("is_authenticated", false);

        return $this->redirectToRoute("app_home");
    }
}
