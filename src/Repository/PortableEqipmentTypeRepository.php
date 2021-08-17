<?php

namespace App\Repository;

use App\Entity\PortableEqipmentType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PortableEqipmentType|null find($id, $lockMode = null, $lockVersion = null)
 * @method PortableEqipmentType|null findOneBy(array $criteria, array $orderBy = null)
 * @method PortableEqipmentType[]    findAll()
 * @method PortableEqipmentType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PortableEqipmentTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PortableEqipmentType::class);
    }

    // /**
    //  * @return PortableEqipmentType[] Returns an array of PortableEqipmentType objects
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
    public function findOneBySomeField($value): ?PortableEqipmentType
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
        return $this->createQueryBuilder('et');
    }

    public function findAllTypes()
    {
        return $this->createQueryBuilder('et')
            ->select('et.type')
            ->getQuery()->getArrayResult();
    }
}
