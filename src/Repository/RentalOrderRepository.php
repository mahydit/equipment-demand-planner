<?php

namespace App\Repository;

use App\Entity\RentalOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RentalOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method RentalOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method RentalOrder[]    findAll()
 * @method RentalOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RentalOrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RentalOrder::class);
    }

    // /**
    //  * @return RentalOrder[] Returns an array of RentalOrder objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RentalOrder
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findAllQuery()
    {
        return $this->createQueryBuilder('o');
    }

    public function findOrderEquipmentsByDate($date)
    {
        return $this->createQueryBuilder('o')
            ->select('s.name AS station, count(e.id) AS count , et.type AS type')
            ->join('o.equipments', 'e')
            ->join('e.type', 'et')
            ->join('o.startStation', 's')
            ->where('DATE(o.startDate) = :date')
            ->setParameter('date', $date)
            ->groupBy('s.id')
            ->addGroupBy('et.id')
            ->getQuery()->getResult();
    }

    public function findEquipmentsOutOfStationsByDate($date)
    {
        return $this->createQueryBuilder('o')
            ->select('s.name AS station, count(e.id) AS count , et.type AS type')
            ->join('o.equipments', 'e')
            ->join('e.type', 'et')
            ->join('o.startStation', 's')
            ->where('DATE(o.startDate) < :date')
            ->setParameter('date', $date)
            ->groupBy('s.id')
            ->addGroupBy('et.id')
            ->getQuery()->getResult();
    }

    public function findEquipmentsReturnedToStationsByDate($date)
    {
        return $this->createQueryBuilder('o')
            ->select('s.name AS station, count(e.id) AS count , et.type AS type')
            ->join('o.equipments', 'e')
            ->join('e.type', 'et')
            ->join('o.startStation', 's')
            ->where('DATE(o.endDate) < :date')
            ->setParameter('date', $date)
            ->groupBy('s.id')
            ->addGroupBy('et.id')
            ->getQuery()->getResult();
    }

}
