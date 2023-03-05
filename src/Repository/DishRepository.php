<?php

namespace App\Repository;

use App\Entity\Dish;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Dish>
 *
 * @method Dish|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dish|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dish[]    findAll()
 * @method Dish[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DishRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dish::class);
    }

    public function save(Dish $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Dish $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Dish[] Returns an array of Dish objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Dish
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function returnPicture(string $id): string
    {
        $dbcon = $this->getEntityManager()->getConnection();

        $query = "SELECT picture FROM dish WHERE id = :val";                         

        $stm = $dbcon->prepare($query);
        $stm->bindValue(":val", $id);                            
        $resultSet = $stm->executeQuery(); 
        $result =  $resultSet->fetchAllAssociative();

        return $result[0]['picture'];
    }

       
    /**
     * getDishesByDishday
     *
     * @param  mixed $dishday
     * @return array
     */
    public function findDishesByDishday(string $dishday): array
    {
        $dbcon = $this->getEntityManager()->getConnection();

        $query = "SELECT * FROM dish
                INNER JOIN dish_day
                ON dish.dish_day_id = dish_day.id
                WHERE dish_day.category_name = :val";
        
        $stm = $dbcon->prepare($query);
        $stm->bindValue(":val", $dishday);
        $result = $stm->executeQuery()->fetchAllAssociative();

        return $result;
    }
}
