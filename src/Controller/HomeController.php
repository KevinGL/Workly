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
            return $this->redirectToRoute("app_login");
        }
        
        return $this->render('home/index.html.twig');
    }
}
