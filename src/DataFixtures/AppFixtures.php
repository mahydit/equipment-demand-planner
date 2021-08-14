<?php

namespace App\DataFixtures;

use App\Entity\Campervan;
use App\Entity\PortableEqipment;
use App\Entity\PortableEqipmentType;
use App\Entity\RentalOrder;
use App\Entity\Station;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{

    /**
     * @var \Faker\Generator
     */
    protected $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        $this->loadPortableEqipmentTypes($manager);
        $this->loadStations($manager);
        $this->loadCampervans($manager);
        $this->loadPortableEqipment($manager);
        $this->loadRentalOrders($manager);
    }

    /**
     * load portable equipments types into db
     * @param ObjectManager $manager
     */
    public function loadPortableEqipmentTypes(ObjectManager $manager)
    {
        $types = [
            'portable toilets',
            'bed sheets',
            'sleeping bags',
            'camping tables',
            'chairs'
        ];

        foreach ($types as $type) {
            $equipmentType = new PortableEqipmentType();
            $equipmentType->setType($type);
            $manager->persist($equipmentType);
        }

        $manager->flush();
    }

    /**
     * load stations into db
     * @param ObjectManager $manager
     */
    public function loadStations(ObjectManager $manager)
    {
        $stations = [
            'Munich',
            'Paris',
            'Porto',
            'Madrid'
        ];

        foreach ($stations as $stationName) {
            $station = new Station();
            $station->setName($stationName);
            $manager->persist($station);
        }

        $manager->flush();
    }

    /**
     * load campervans into db
     * @param ObjectManager $manager
     */
    public function loadCampervans(ObjectManager $manager)
    {
        foreach (range(1, 10) as $i) {
            $campervan = new Campervan();
            $campervan
                ->setCarNumber('carnumber-'.$i)
                ->setBrand($this->faker->word)
                ->setIsOnTheRoad(false);

            $manager->persist($campervan);
        }
        $manager->flush();
    }

    /**
     * load portable equipments into db
     * @param ObjectManager $manager
     */
    public function loadPortableEqipment(ObjectManager $manager)
    {
        $types = $manager->getRepository(PortableEqipmentType::class)->findAll();

        foreach (range(1, 10) as $i) {
            $equipment = new PortableEqipment();
            $equipment
                ->setType($types[rand(0,count($types)-1)])
                ->setIsUsed(false)
                ->setDescription($this->faker->text(50))
            ;

            $manager->persist($equipment);
        }
        $manager->flush();

    }

    /**
     * load portable rental orders into db and update starting station of campervan and equipments
     * @param ObjectManager $manager
     */
    public function loadRentalOrders(ObjectManager $manager)
    {
        $rentalOrders = [
            [
                'Porto',
                'Paris',
                0,
                (new \DateTime('+29 days')),
                (new \DateTime('+33 days')),
                [0]
            ],
            [
                'Munich',
                'Paris',
                1,
                (new \DateTime('+30 days')),
                (new \DateTime('+32 days')),
                [1,2]
            ],
            [
                'Porto',
                'Munich',
                2,
                (new \DateTime('+30 days')),
                (new \DateTime('+33 days')),
                [3]
            ],
            [
                'Madrid',
                'Paris',
                3,
                (new \DateTime('+29 days')),
                (new \DateTime('+33 days')),
                []
            ],
            [
                'Porto',
                'Madrid',
                4,
                (new \DateTime('+27 days')),
                (new \DateTime('+31 days')),
                [4]
            ],
            [
                'Munich',
                'Madrid',
                5,
                (new \DateTime('+30 days')),
                (new \DateTime('+33 days')),
                [5,6,7]
            ],
            [
                'Munich',
                'Porto',
                6,
                (new \DateTime('+30 days')),
                (new \DateTime('+35 days')),
                [8]
            ],
            [
                'Paris',
                'Madrid',
                7,
                (new \DateTime('+33 days')),
                (new \DateTime('+36 days')),
                [1]
            ],
            [
                'Munich',
                'Porto',
                8,
                (new \DateTime('+34 days')),
                (new \DateTime('+36 days')),
                [9,3]
            ],
            [
                'Paris',
                'Porto',
                9,
                (new \DateTime('+32 days')),
                (new \DateTime('+36 days')),
                []
            ]
        ];

        $campervans = $manager->getRepository(Campervan::class)->findAll();
        $equipments = $manager->getRepository(PortableEqipment::class)->findAll();
        foreach ($rentalOrders as [$startStation, $endStation, $campervanId, $startDate, $endDate, $equipmentIds]) {
            $startStationObj = $manager->getRepository(Station::class)->findOneBy(['name' => $startStation]);
            $endStationObj = $manager->getRepository(Station::class)->findOneBy(['name' => $endStation]);
            $campervan = $campervans[$campervanId];
            $this->updateAtStation($campervan, $startStationObj);

            $order = new RentalOrder();
            $order->setStartStation($startStationObj)
                ->setEndStation($endStationObj)
                ->setStartDate($startDate)
                ->setEndDate($endDate)
                ->setCampervan($campervan);

            foreach ($equipmentIds as $id) {
                $equipment = $equipments[$id];
                $order->addEquipment($equipment);
                $this->updateAtStation($equipment, $startStationObj);
            }

            $manager->persist($order);
        }
        $manager->flush();
    }

    /**
     * update atStation for campervans/equipments
     * @param $object
     * @param $station
     */
    private function updateAtStation($object, $station)
    {
        $object->setAtStation($station);
    }

}
