<?php

namespace App\Repository;

use App\Entity\PortableEqipment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PortableEqipment|null find($id, $lockMode = null, $lockVersion = null)
 * @method PortableEqipment|null findOneBy(array $criteria, array $orderBy = null)
 * @method PortableEqipment[]    findAll()
 * @method PortableEqipment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PortableEqipmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PortableEqipment::class);
    }

    // /**
    //  * @return PortableEqipment[] Returns an array of PortableEqipment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PortableEqipment
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findAllQuery()
    {
        return $this->createQueryBuilder('e');
    }
}
