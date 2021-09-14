<?php

namespace App\Repository;

use App\Entity\Reponse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Reponse|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reponse|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reponse[]    findAll()
 * @method Reponse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReponseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reponse::class);
    }

    /**
     * @return Reponse[] Returns an array of Reponse objects
     */

    public function countReponsesByUser()
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('COUNT(r) as nbReponses, u.id, u.pseudo')
            ->from('App\Entity\Reponse', 'r')
            ->from('App\Entity\User', 'u')
            ->where('r.user = r.id')
            ->groupBy('u.id')
            ->getQuery()
            ->getResult();
    }



    /*
    public function findOneBySomeField($value): ?Reponse
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
