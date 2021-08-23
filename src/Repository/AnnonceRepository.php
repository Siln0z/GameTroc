<?php

namespace App\Repository;

use App\Entity\Annonce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Annonce|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annonce|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annonce[]    findAll()
 * @method Annonce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonce::class);
    }

    // public function findAll()
    // {
    //     return $this->findBy([], array('id' => 'ASC'));
    // }


    /**
     * @return Annonce[] Returns an array of Annonce objects
     */

    public function findTroisDernieresAnnonces()
    {
        // $now = new \DateTime();
        return $this->createQueryBuilder('a')
            // ->andWhere('a.dateCreation > :now')
            // ->setParameter('now', $now->format('Y-m-d'))
            ->orderBy('a.dateCreation', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Annonce
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
