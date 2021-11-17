<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(EntityManagerInterface $manager): Response
    {
        //récupération de tous les catégories pour proposer une recherche des articles par catégorie
        //$manager va appeler le repository
        //Fonction getRepository(classe_Entity::class) retourne un objet de la classe repository (ici un CategoryRepository)
        $repository = $manager -> getRepository(Category::class);
        //Avec l'objet repository vous pouvez appeler les fonctions définies dans la classe repository (CategoryRepository)
        $categories = $repository -> findAll();

        return $this->render('home/index.html.twig', [
            'categories' => $categories
        ]);
    }
    
}
