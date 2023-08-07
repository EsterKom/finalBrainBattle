<?php

namespace App\Controller;

use App\Entity\Level;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LevelController extends AbstractController
{
    #[Route('/level', name: 'app_level')]
    public function index(): Response
    {
        return $this->render('level/index.html.twig', [
            'controller_name' => 'LevelController',
        ]);
    }

    public function createLevel(EntityManagerInterface $entityManager): Response
    {
        $level = new Level();
        $level->setName('Easy');
        $level->setDescription('We all start as babies! Baby step, baby! ');

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($level);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new level with id '.$level->getId());
    }
}
