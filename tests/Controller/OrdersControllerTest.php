<?php

namespace App\Tests\Controller;

use App\Entity\Orders;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class OrdersControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/orders/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Orders::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Order index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'order[tableNumber]' => 'Testing',
            'order[peopleQty]' => 'Testing',
            'order[aperitifs]' => 'Testing',
            'order[aperitifsQty]' => 'Testing',
            'order[aperitifsFinished]' => 'Testing',
            'order[firsts]' => 'Testing',
            'order[firstsQty]' => 'Testing',
            'order[firstsFinished]' => 'Testing',
            'order[seconds]' => 'Testing',
            'order[secondsQty]' => 'Testing',
            'order[secondsFinished]' => 'Testing',
            'order[desserts]' => 'Testing',
            'order[dessertsQty]' => 'Testing',
            'order[dessertsFinished]' => 'Testing',
            'order[drinks]' => 'Testing',
            'order[drinksQty]' => 'Testing',
            'order[drinksFinished]' => 'Testing',
            'order[coffees]' => 'Testing',
            'order[coffeesQty]' => 'Testing',
            'order[coffeesFinished]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Orders();
        $fixture->setTableNumber('My Title');
        $fixture->setPeopleQty('My Title');
        $fixture->setAperitifs('My Title');
        $fixture->setAperitifsQty('My Title');
        $fixture->setAperitifsFinished('My Title');
        $fixture->setFirsts('My Title');
        $fixture->setFirstsQty('My Title');
        $fixture->setFirstsFinished('My Title');
        $fixture->setSeconds('My Title');
        $fixture->setSecondsQty('My Title');
        $fixture->setSecondsFinished('My Title');
        $fixture->setDesserts('My Title');
        $fixture->setDessertsQty('My Title');
        $fixture->setDessertsFinished('My Title');
        $fixture->setDrinks('My Title');
        $fixture->setDrinksQty('My Title');
        $fixture->setDrinksFinished('My Title');
        $fixture->setCoffees('My Title');
        $fixture->setCoffeesQty('My Title');
        $fixture->setCoffeesFinished('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Order');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Orders();
        $fixture->setTableNumber('Value');
        $fixture->setPeopleQty('Value');
        $fixture->setAperitifs('Value');
        $fixture->setAperitifsQty('Value');
        $fixture->setAperitifsFinished('Value');
        $fixture->setFirsts('Value');
        $fixture->setFirstsQty('Value');
        $fixture->setFirstsFinished('Value');
        $fixture->setSeconds('Value');
        $fixture->setSecondsQty('Value');
        $fixture->setSecondsFinished('Value');
        $fixture->setDesserts('Value');
        $fixture->setDessertsQty('Value');
        $fixture->setDessertsFinished('Value');
        $fixture->setDrinks('Value');
        $fixture->setDrinksQty('Value');
        $fixture->setDrinksFinished('Value');
        $fixture->setCoffees('Value');
        $fixture->setCoffeesQty('Value');
        $fixture->setCoffeesFinished('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'order[tableNumber]' => 'Something New',
            'order[peopleQty]' => 'Something New',
            'order[aperitifs]' => 'Something New',
            'order[aperitifsQty]' => 'Something New',
            'order[aperitifsFinished]' => 'Something New',
            'order[firsts]' => 'Something New',
            'order[firstsQty]' => 'Something New',
            'order[firstsFinished]' => 'Something New',
            'order[seconds]' => 'Something New',
            'order[secondsQty]' => 'Something New',
            'order[secondsFinished]' => 'Something New',
            'order[desserts]' => 'Something New',
            'order[dessertsQty]' => 'Something New',
            'order[dessertsFinished]' => 'Something New',
            'order[drinks]' => 'Something New',
            'order[drinksQty]' => 'Something New',
            'order[drinksFinished]' => 'Something New',
            'order[coffees]' => 'Something New',
            'order[coffeesQty]' => 'Something New',
            'order[coffeesFinished]' => 'Something New',
        ]);

        self::assertResponseRedirects('/orders/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTableNumber());
        self::assertSame('Something New', $fixture[0]->getPeopleQty());
        self::assertSame('Something New', $fixture[0]->getAperitifs());
        self::assertSame('Something New', $fixture[0]->getAperitifsQty());
        self::assertSame('Something New', $fixture[0]->getAperitifsFinished());
        self::assertSame('Something New', $fixture[0]->getFirsts());
        self::assertSame('Something New', $fixture[0]->getFirstsQty());
        self::assertSame('Something New', $fixture[0]->getFirstsFinished());
        self::assertSame('Something New', $fixture[0]->getSeconds());
        self::assertSame('Something New', $fixture[0]->getSecondsQty());
        self::assertSame('Something New', $fixture[0]->getSecondsFinished());
        self::assertSame('Something New', $fixture[0]->getDesserts());
        self::assertSame('Something New', $fixture[0]->getDessertsQty());
        self::assertSame('Something New', $fixture[0]->getDessertsFinished());
        self::assertSame('Something New', $fixture[0]->getDrinks());
        self::assertSame('Something New', $fixture[0]->getDrinksQty());
        self::assertSame('Something New', $fixture[0]->getDrinksFinished());
        self::assertSame('Something New', $fixture[0]->getCoffees());
        self::assertSame('Something New', $fixture[0]->getCoffeesQty());
        self::assertSame('Something New', $fixture[0]->getCoffeesFinished());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Orders();
        $fixture->setTableNumber('Value');
        $fixture->setPeopleQty('Value');
        $fixture->setAperitifs('Value');
        $fixture->setAperitifsQty('Value');
        $fixture->setAperitifsFinished('Value');
        $fixture->setFirsts('Value');
        $fixture->setFirstsQty('Value');
        $fixture->setFirstsFinished('Value');
        $fixture->setSeconds('Value');
        $fixture->setSecondsQty('Value');
        $fixture->setSecondsFinished('Value');
        $fixture->setDesserts('Value');
        $fixture->setDessertsQty('Value');
        $fixture->setDessertsFinished('Value');
        $fixture->setDrinks('Value');
        $fixture->setDrinksQty('Value');
        $fixture->setDrinksFinished('Value');
        $fixture->setCoffees('Value');
        $fixture->setCoffeesQty('Value');
        $fixture->setCoffeesFinished('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/orders/');
        self::assertSame(0, $this->repository->count([]));
    }
}
