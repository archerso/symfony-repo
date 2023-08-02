<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureType;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VoitureController extends AbstractController
{
    #[Route('/voiture', name: 'voiture')]
    public function index(VoitureRepository $repo): Response
    {
        $voitures = $repo->findAll();
        $this->render('voiture/index.html.twig', [
            'items' => $voitures,
        ]);
    }

    
    
    #[Route('/voiture/ajout', name: 'voiture_ajout')]
    // Request permet de recupeer les GLOBAL, 
    public function ajout(Request $request, EntityManagerInterface $manager): Response
    {
        $voiture = new Voiture;
    // je crée une variable dans laquelle je stocke mon formulaire crée grace à createForm() et a son formBuilder (VoitureType)
    // click droit pour importer la class

    // 
        $form = $this->createForm(VoitureType::class, $voiture);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($voiture);
            // persist() permet de préparer les requette SQL par rapport à l'objet qu'on lui donne enn paramètre
            $manager->flush();
            // flus() permet d'executer toutes les requettes précédentes
            return $this->redirectToRoute('home');

        }
        // dans render le se second le premier parametre est le chemin le SECOND EST UN TABLEAU
        return $this->render('voiture/ajout.html.twig', [
            'formVoiture' => $form,
        ]);
    }

    
}
