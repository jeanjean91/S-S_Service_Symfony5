<?php

namespace App\Repository;

use App\Entity\Categorys;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Categorys|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categorys|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categorys[]    findAll()
 * @method Categorys[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorysRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorys::class);
    }

    // /**
    //  * @return Categorys[] Returns an array of Categorys objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    /**
     * return les catégories de niveau 1 (ces catégories contiennent des sous-catégories qui contiennent des sous-sous-catégories)
     * */
    public function findCatFirstLevel() : array
    {
        $query = $this->_em->createQuery('SELECT c FROM App\Entity\Categorys c WHERE c.id = c.categorys');
        $results = $query->getResult();
//         $qb = $this->createQueryBuilder('a');

//         $qb
//         ->where('a.categorie_id = :cat')
//         ->setParameter('cat', null);

//         return $qb
//         ->getQuery()
//         ->getResult()
//         ;
        return $results;
    }

    /*
    public function findOneBySomeField($value): ?Categorys
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
