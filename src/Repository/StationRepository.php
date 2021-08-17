<?php

namespace App\Repository;

use App\Entity\Station;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Station|null find($id, $lockMode = null, $lockVersion = null)
 * @method Station|null findOneBy(array $criteria, array $orderBy = null)
 * @method Station[]    findAll()
 * @method Station[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Station::class);
    }

    // /**
    //  * @return Station[] Returns an array of Station objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Station
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findAllQuery()
    {
        return $this->createQueryBuilder('s');
    }

    public function findAvailableEquipments()
    {
        return $this->createQueryBuilder('s')
            ->select('s.name AS station, count(e.id) AS count , et.type AS type')
            ->join('s.portableEqipments', 'e')
            ->join('e.type', 'et')
            ->where('e.atStation is NOT NULL')
            ->groupBy('s.id')
            ->addGroupBy('et.id')
            ->getQuery()->getResult();
    }

    public function findAllStationNames()
    {
        return $this->createQueryBuilder('s')
            ->select('s.name')
            ->getQuery()->getArrayResult();
    }
}
