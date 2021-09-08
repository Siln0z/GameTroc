<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Annonce;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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
        return $this->createQueryBuilder('a')
            ->orderBy('a.dateCreation', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    public function countAnnonces()
    {
        return $this->createQueryBuilder('a')
            ->select('count(a.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countAnnoncesByUser()
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('COUNT(a) as nbAnnonces, u.pseudo, u.id, u.avatar, u.banni, u.roles')
            ->from('App\Entity\Annonce', 'a')
            ->from('App\Entity\User', 'u')
            ->where('a.user = u.id')
            ->groupBy('u.id')
            ->getQuery()
            ->getResult();
    }
}
