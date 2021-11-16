<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExemplesController extends AbstractController
{
    /**
     * @Route("/exemples", name="exemples")
     */
    public function indexArticle(): Response
    {

        //1) Un tableau avec des nombres aléatoires ceux ci seront affichés de manière de séparer le nombre paires de nombres impaires
        // Création des tables
        $tabAleat = [];
        $tabPair = [];
        $tabImpair = [];
        $nombre = rand(1,20);
        for($i = 0; $i < $nombre; $i++) {
            array_push($tabAleat, rand(1, 20));
        }

        //2) Afficher le premier élément d'un tableau de string
        $tabString = ["alain", "pierre", "martin", "natacha", "fatiha", "mickaël"];
        //3) Afficher chaque élément de votre tableau de string avec la première lettre en majuscule
        //4) Afficher le plus grand nombre de votre tableau de nombre
        //5) Afficher aléatoirement une des valeurs de votre tableau
        //6) Envoyer une date et faire un affichage différent si la date est supérieure ou inférieure à celle d'aujourd'hui
        //Date aléatoire (inclus des dates passées et en future)
        $timestamp = mt_rand(1, 2147385600);

        //Print it out.
        $dateAléatoire = date("Y-m-d", $timestamp);
        

        return $this->render('exemples/index.html.twig', [
            'controller_name'   => 'ArticleController',
            'tabAleatoire'      => $tabAleat,
            'tabPair'           => $tabPair,        
            'tabImpair'         => $tabImpair, 
            'tabString'         => $tabString,
            'dateAleatoire'     => $dateAléatoire      
        ]);
    }
}
