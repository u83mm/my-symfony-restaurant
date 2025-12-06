<?php

namespace App\Repository;

use App\Entity\Dish;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
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
    public const PAGINATOR_PER_PAGE = 6;

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

    /**
     * This PHP function retrieves a picture from a database based on a given ID.
     * 
     * @param string id The parameter "id" is a string variable that represents the unique identifier
     * of a dish in a database table. The function "returnPicture" retrieves the picture of the dish
     * with the specified id from the database and returns it as a string.
     * 
     * @return string a string which represents the picture of a dish with the given ID.
     */
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

        $query = "SELECT dish.id as id, dish.name as name FROM dish
                INNER JOIN dish_day
                ON dish.dish_day_id = dish_day.id
                WHERE dish_day.category_name = :val
                AND dish.available = true";
        
        $stm = $dbcon->prepare($query);
        $stm->bindValue(":val", $dishday);
        $result = $stm->executeQuery()->fetchAllAssociative();

        return $result;              
    }  

    /**
     * @return Dish[] Returns an array of Dish objects
     */
    public function selectDishesByCritery(int $offset, string $field, string $searchTerm): Paginator
    {        
        $query = $this->createQueryBuilder('d')        
        ->where("d.$field LIKE :searchTerm")
        ->setParameter('searchTerm', '%'.$searchTerm.'%')
        ->setMaxResults(self::PAGINATOR_PER_PAGE)
        ->setFirstResult($offset)
        ->getQuery();        

        return new Paginator($query);
    }

    public function getDishPaginator(int $offset, ?string $field = null, mixed $value = null): Paginator
    {        
        if(isset($field) && isset($value)) {
            $query = $this->createQueryBuilder('d')
            ->andWhere("d.$field = :val")
            ->setParameter('val', $value)
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery();
        }
        else {
            $query = $this->createQueryBuilder('d')
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery();
        }        

        return new Paginator($query);
    }

    public function getMenuDayElements(): array
    {               
        /** Show diferent Day's menu dishes */
        return [
            'primeros' => $this->findDishesByDishday('primero'),
            'segundos' => $this->findDishesByDishday('segundo'),
            'postres'  => $this->findDishesByDishday('postre'),
        ];
    }
}
