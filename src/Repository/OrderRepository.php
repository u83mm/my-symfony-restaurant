<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Order>
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function save(Order $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function update(Order $entity, bool $flush = false): void
    {
        // Update the order
        if($entity->getAperitifs() !== null && isset($_POST['aperitifs_qty'])) {
            $aperitifs = $entity->getAperitifs();
            $entity->cleanAperitifs();

            foreach($_POST['aperitifs_qty'] as $key => $value) {
                if($value != 0) {
                    $aperitifs[$key]['qty'] = $value;
                    $aperitifs[$key]['finished'] = $_POST['aperitifs_finished'][$key];                
                    $entity->setAperitifs($aperitifs[$key]);
                }
            }
        }  
        if($entity->getFirsts() !== null && isset($_POST['firsts_qty'])) {
            $firsts = $entity->getFirsts();
            $entity->cleanFirsts();            

            foreach($_POST['firsts_qty'] as $key => $value) {
                if($value != 0) {
                    $firsts[$key]['qty'] = $value; 
                    $firsts[$key]['finished'] = $_POST['firsts_finished'][$key];               
                    $entity->setFirsts($firsts[$key]);                    
                }
            }
        }
        if($entity->getSeconds() !== null && isset($_POST['seconds_qty'])) {
            $seconds = $entity->getSeconds();
            $entity->cleanSeconds();

            foreach($_POST['seconds_qty'] as $key => $value) {
                if($value != 0) {
                    $seconds[$key]['qty'] = $value; 
                    $seconds[$key]['finished'] = $_POST['seconds_finished'][$key];               
                    $entity->setSeconds($seconds[$key]);
                }              
            }                        
        }
        if($entity->getDrinks() !== null && isset($_POST['drinks_qty'])) {
            $drinks = $entity->getDrinks();
            $entity->cleanDrinks();

            foreach($_POST['drinks_qty'] as $key => $value) {
                if($value != 0) {
                    $drinks[$key]['qty'] = $value;
                    $drinks[$key]['finished'] = $_POST['drinks_finished'][$key];                
                    $entity->setDrinks($drinks[$key]);
                }
            }
        }
        if($entity->getDesserts() !== null && isset($_POST['desserts_qty'])) {
            $desserts = $entity->getDesserts();
            $entity->cleanDesserts();

            foreach($_POST['desserts_qty'] as $key => $value) {
                if($value != 0) {
                    $desserts[$key]['qty'] = $value;
                    $desserts[$key]['finished'] = $_POST['desserts_finished'][$key];               
                    $entity->setDesserts($desserts[$key]);
                }                                
            }
        }
        if($entity->getCoffees() !== null && isset($_POST['coffees_qty'])) {
            $coffees = $entity->getCoffees();
            $entity->cleanCoffees();

            foreach($_POST['coffees_qty'] as $key => $value) {
                if($value != 0) {
                    $coffees[$key]['qty'] = $value;
                    $coffees[$key]['finished'] = $_POST['coffees_finished'][$key];                
                    $entity->setCoffees($coffees[$key]);
                }                             
            }
        }

        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Order $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function testIfTheTableIsBussy(int $number): bool
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT table_number FROM `order` WHERE table_number = :number';
        $stmt = $conn->prepare($sql);          
        $result = $stmt->executeQuery(['number' => $number]);
        
        return $result->rowCount() > 0 ? true : false;
    }

    public function addDishesToAnExistingOrder(array $dishes, Order $order): void {
        foreach ($dishes as $dish) {

            // Aperitifs
            if($dish['category'] == 'aperitifs') {
                $apperitifs = $order->getAperitifs();
                $order->cleanAperitifs();

                if($apperitifs !== null) {
                    foreach ($apperitifs as $aperitifKey => $aperitif) {
                        if($aperitif['name'] == $dish['name']) {
                            $apperitifs[$aperitifKey]['qty'] += $dish['qty'];                                                      
                            break;
                        }
                        else if(count($apperitifs) == $aperitifKey + 1) {
                            $apperitifs[] = $dish;                            
                        }                                                
                    }
                    
                    foreach ($apperitifs as $value) {
                        $order->setAperitifs($value);
                    }
                }
                else {
                    $order->setAperitifs($dish);
                }
            }

            // Firsts
            if($dish['category'] == 'firsts') {
                $firsts = $order->getFirsts();
                $order->cleanFirsts();

                if($firsts !== null) {
                    foreach ($firsts as $firstKey => $first) {
                        if($first['name'] == $dish['name']) {
                            $firsts[$firstKey]['qty'] += $dish['qty'];                                                      
                            break;
                        }
                        else if(count($firsts) == $firstKey + 1) {
                            $firsts[] = $dish;                            
                        }                                                
                    }
                    
                    foreach ($firsts as $value) {
                        $order->setFirsts($value);
                    }
                }
                else {
                    $order->setFirsts($dish);
                }
            }

            // Seconds
            if($dish['category'] == 'seconds') {
                $seconds = $order->getSeconds();
                $order->cleanSeconds();

                if($seconds !== null) {
                    foreach ($seconds as $secondKey => $second) {
                        if($second['name'] == $dish['name']) {
                            $seconds[$secondKey]['qty'] += $dish['qty'];                                                      
                            break;
                        }
                        else if(count($seconds) == $secondKey + 1) {
                            $seconds[] = $dish;                            
                        }                                                
                    }
                    
                    foreach ($seconds as $value) {
                        $order->setSeconds($value);
                    }
                }
                else {
                    $order->setSeconds($dish);
                }
            }

            // Drinks
            if($dish['category'] == 'drinks') {
                $drinks = $order->getDrinks();
                $order->cleanDrinks();

                if($drinks !== null) {
                    foreach ($drinks as $drinkKey => $drink) {
                        if($drink['name'] == $dish['name']) {
                            $drinks[$drinkKey]['qty'] += $dish['qty'];                                                      
                            break;
                        }
                        else if(count($drinks) == $drinkKey + 1) {
                            $drinks[] = $dish;                            
                        }                                                
                    }
                    
                    foreach ($drinks as $value) {
                        $order->setDrinks($value);
                    }
                }
                else {
                    $order->setDrinks($dish);
                }
            }

            // Desserts
            if($dish['category'] == 'desserts') {
                $desserts = $order->getDesserts();
                $order->cleanDesserts();

                if($desserts !== null) {
                    foreach ($desserts as $dessertKey => $dessert) {
                        if($dessert['name'] == $dish['name']) {
                            $desserts[$dessertKey]['qty'] += $dish['qty'];                                                      
                            break;
                        }
                        else if(count($desserts) == $dessertKey + 1) {
                            $desserts[] = $dish;                            
                        }                                                
                    }
                    
                    foreach ($desserts as $value) {
                        $order->setDesserts($value);
                    }
                }
                else {
                    $order->setDesserts($dish);
                }
            }

            // Coffees
            if($dish['category'] == 'coffees') {
                $coffees = $order->getCoffees();
                $order->cleanCoffees();

                if($coffees !== null) {
                    foreach ($coffees as $coffeeKey => $coffee) {
                        if($coffee['name'] == $dish['name']) {
                            $coffees[$coffeeKey]['qty'] += $dish['qty'];                                                      
                            break;
                        }
                        else if(count($coffees) == $coffeeKey + 1) {
                            $coffees[] = $dish;                            
                        }                                                
                    }
                    
                    foreach ($coffees as $value) {
                        $order->setCoffees($value);
                    }
                }
                else {
                    $order->setCoffees($dish);
                }
            }
        }
    }

    //    /**
    //     * @return Order[] Returns an array of Order objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('o.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Order
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
