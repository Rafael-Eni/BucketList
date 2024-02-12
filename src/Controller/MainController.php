<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'app')]
class MainController extends AbstractController
{
    #[Route('/', name: '_main')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig');
    }

    #[Route('/about', name: '_about')]
    public function about(): Response
    {
        return $this->render('main/about.html.twig');
    }
}
