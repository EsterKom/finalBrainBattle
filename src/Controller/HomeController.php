<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            // 'controller_name' => 'HomeController',
        ]);
    }


    #[Route('/aboutus', name: 'app_aboutus', methods: ['GET'])]
    // add a contact Us
    public function aboutUs(): Response
    {
        return $this->render('home/aboutus.html.twig', [
            // 'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/contact', name: 'app_contact', methods: ['GET'])]
    // add a contact Us
    public function contact(): Response
    {
        return $this->render('home/contact.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}