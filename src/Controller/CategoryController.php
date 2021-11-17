<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\CategoryType;

class CategoryController extends AbstractController
{
    //définition route 1 => affichage de touts les articles de la base de données
    /**
     * @Route("/categorie", name="categorie")
     */
    public function indexCategories(EntityManagerInterface $manager): Response {
        //$manager va appeler le repository
        //Fonction getRepository(classe_Entity::class) retourne un objet de la classe repository (ici un ArticleRepository)
        $repository = $manager -> getRepository(Category::class);
        //Avec l'objet repository vous pouvez appeler les fonctions définies dans la classe repository (ArticleRepository)
        $categories = $repository -> findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories         
        ]);
    }
    //définition route 2 => creation catégorie et insertion BD
    /**
     * @Route("categorie/creation", name="categorie_creation")
     */
    public function indexCategorieCreate(Request $request): Response {

        //création objet article
        $categorie = new Category();
        
        //form
        //création objet form
        $form = $this -> createForm(CategoryType::class, $categorie);
        $form -> handleRequest($request);
        //si le form est submit et validé => récupération de données rentrée dans la variable $article
        if($form -> isSubmitted() && $form -> isValid()) {
            $categorie = $form -> getData();
            
            // insértion dans la base de données
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categorie);
            $entityManager->flush();

            return $this->redirectToRoute('categorie', [
                
                ]);
        }

        return $this->render('category/creationCategory.html.twig', [
            'form' => $form->createView()
            ]);
    }
}
