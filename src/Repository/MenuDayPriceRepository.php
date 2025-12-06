<?php

namespace App\Repository;

use App\Entity\MenuDayPrice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MenuDayPrice>
 *
 * @method MenuDayPrice|null find($id, $lockMode = null, $lockVersion = null)
 * @method MenuDayPrice|null findOneBy(array $criteria, array $orderBy = null)
 * @method MenuDayPrice[]    findAll()
 * @method MenuDayPrice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MenuDayPriceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MenuDayPrice::class);
    }

    public function save(MenuDayPrice $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MenuDayPrice $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function truncateTable(string $table): void
    {
        $dbcon = $this->getEntityManager()->getConnection();

        $query = "TRUNCATE TABLE $table";

        $stm = $dbcon->prepare($query);       
        $stm->executeQuery();
    }

//    /**
//     * @return MenuDayPrice[] Returns an array of MenuDayPrice objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MenuDayPrice
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
