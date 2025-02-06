<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reservation>
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    public function save(Reservation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }    

    /**
     * @return Reservation[] Returns an array of Reservation objects
     */
    public function findAll(): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.date >= CURRENT_DATE()')           
            ->orderBy('r.date', 'ASC')            
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Reservation[] Returns an array of Reservation objects
     */
    public function findByDateAndTime($date, $time = null): array
    {
        if($time) {
            return $this->createQueryBuilder('r')
            ->andWhere('r.date = :date')
            ->andWhere('r.time = :time')
            ->setParameter('date', $date)
            ->setParameter('time', $time)
            ->orderBy('r.time', 'ASC')            
            ->getQuery()
            ->getResult()
        ;

        }
        return $this->createQueryBuilder('r')
            ->andWhere('r.date = :date')
            ->setParameter('date', $date)
            ->orderBy('r.time', 'ASC')            
            ->getQuery()
            ->getResult()
        ;
    }

    //    /**
    //     * @return Reservation[] Returns an array of Reservation objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Reservation
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
