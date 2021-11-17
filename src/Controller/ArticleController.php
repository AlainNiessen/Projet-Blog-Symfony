<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;
use App\Entity\Article;
use App\Entity\Category;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;


class ArticleController extends AbstractController
{
    //définition route 1 => affichage de touts les articles de la base de données
    /**
     * @Route("/article", name="article")
     */
    public function indexArticles(EntityManagerInterface $manager): Response {
        //$manager va appeler le repository
        //Fonction getRepository(classe_Entity::class) retourne un objet de la classe repository (ici un ArticleRepository)
        $repository = $manager -> getRepository(Article::class);
        //Avec l'objet repository vous pouvez appeler les fonctions définies dans la classe repository (ArticleRepository)
        $articles = $repository -> findAll();

        return $this->render('article/index.html.twig', [
            'articles' => $articles         
        ]);
    }
    
    //définition route 2 => choix de article pour voter
    /**
     * @Route("/article/vote/{number}", name="article_vote")
     */
    public function indexArticleDetail($number): Response
    {
        return $this->render('article/vote.html.twig', [
            'number' => $number,
            'votes' => rand(1, 100)            
        ]);
    }

    //définition route 3 => return JSON
    /**
     * @Route("article/actionVote", name="vote")
     */
    //IMPORTANT => cette route renvoie un réponse JSON, pas de traitement via TWIG (donc pas de render)
    public function indexArticleVote(): JsonResponse {
        //déclaration variable votes qui sera envoyer via JSON
        $tabInfo = ['votes' => rand(1, 100)];

        return new JsonResponse($tabInfo);
    
    }

    //définition route 4 => creation article et insertion BD
    /**
     * @Route("article/creation", name="article_creation")
     */
    public function indexArticleCreate(Request $request): Response {

        //création objet article
        $article = new Article();
        //création date de création
        $article -> setDateDeCreation(new DateTime());
        //string pour affichage
        $dateCreationString = $article -> getDateDeCreation() -> format('Y-m-d');

        //form
        //création objet form
        $form = $this -> createForm(ArticleType::class, $article);
        $form -> handleRequest($request);
        //si le form est submit et validé => récupération de données rentrée dans la variable $article
        if($form -> isSubmitted() && $form -> isValid()) {
            $article = $form -> getData();
            
            // insértion dans la base de données
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('affichage_article', [
                'id' => $article->getId()
                ]);
        }

        return $this->render('article/creationArticle.html.twig', [
            'form' => $form->createView()
            ]);
    }

    //définition route 5 => récupération des articles par année
    /**
     * @route("article/annee/{annee}", name="annee")
     */
    public function indexArticleAnnee($annee, ArticleRepository $manager): Response {

        $articles = $manager -> findbyYear($annee);       

        return $this->render('article/affichageArticleAnnee.html.twig', [
            'articles' => $articles,
            'annee' => $annee       
        ]);

    }


    //definition route 6 => récupération des articles qui contiennent le mot "magique" dans leur contenu
    /**
     * @route("article/content", name="affichage_article_magique")
     */
    public function indexArticleMagique(ArticleRepository $manager): Response {

        $articles = $manager -> findByContent('magique');

        return $this->render('article/affichageArticlesMag.html.twig', [
            'articles' => $articles         
        ]);
    }

    
    //définition route 7 => récupération des détails via une requête automatique (passer l'entity article comme paramétre)
    //EntityManager est appelé automatiquement! => pas besoin de l'appeler
    //ATTENTION: c'est un raccourci pour des requêtes simples
    /**
     * @route("article/id/{id}", name="affichage_article")
     */
    public function indexOneArticle(Article $article): Response {
     
        //Solution Entity Manager classique => pas besoin dans une requête automatique
        //$manager va appeler le repository
        //Fonction getRepository(classe_Entity::class) retourne un objet de la classe repository (ici un ArticleRepository)
        //$repository = $manager -> getRepository(Article::class);
        //Avec l'objet repository vous pouvez appeler les fonctions définies dans la classe repository (ArticleRepository)
        //$article = $repository -> find($id_article);
        //dd($articles);
        //traitement coleur affichage du score
        $class = "";
        $nombreVotes = $article -> getVotes();
        if( $nombreVotes > 0) {
            $class = "green";
        } else if ($nombreVotes < 0) {
            $class = "red";
        } else {
            $class= "orange";
        }

        return $this->render('article/affichageDetail.html.twig', [
            'article' => $article, 
            'class' => $class        
        ]);
    }

    //définition route 8 => votes
    /**
     * @route("article/votes/{id}", name="article_votes", methods="POST")
     */
    public function indexVotes(Article $article, Request $request, EntityManagerInterface $manager) {
        //récupération de la direction
        $direction = $request -> request -> get('direction');
        //actualisation valeur vote
        if($direction === "up") {
            $article -> upVote();
            $article -> nombreVotesUp();
        } elseif ($direction === "down") {
            $article -> downVote();
            $article -> nombreVotesDown();
        }

        $article -> nombreVotesTotal();

        //actualisation bd
        $manager -> flush();

        //traitement coleur affichage du score
        $class = "";
        $nombreVotes = $article -> getVotes();
        if( $nombreVotes > 0) {
            $class = "green";
        } else if ($nombreVotes < 0) {
            $class = "red";
        } else {
            $class= "orange";
        }

        //réaffichage vote actuelle
        return $this->render('article/affichageDetail.html.twig', [
            'article' => $article,
            'class' => $class        
        ]);
    }  
    
    //définition route 9 => affichage des articles par catégories
    /**
     * @route("article/category/{id}", name="article_categorie")
     */
    public function requeteParCategorie(Category $category): Response
    {
        $articles = $category -> getArticles();

        return $this->render('article/affichageArticlesCategorie.html.twig', [
            'articles' => $articles,
            'categorie' => $category                    
        ]);
    }

    

}
