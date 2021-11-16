<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    //recherche par un mot spécifique dans le contenu    
    public function findByContent($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.contenu LIKE :val')
            ->setParameter('val', '%'.$value.'%')
            ->getQuery()
            ->getResult()
        ;
    }

    //recherche par année
    public function findbyYear($value) {

        //ATTENTION => la fonction YEAR n'existe pas, il faut installer DoctrineExtensions
        // => composer require beberlei/doctrineextensions
        $emConfig = $this->getEntityManager()->getConfiguration();
        $emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');

        return $this->createQueryBuilder('a')
            ->where('YEAR(a.date_de_creation) = :year')
            ->setParameter('year', $value)
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
