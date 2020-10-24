<?php


namespace App\DataFixtures;


use App\Entity\Building;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class BuildingFixtures extends Fixture implements FixtureGroupInterface
{

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $building = new Building();
            $building->setName("THE SUN AVENUE" . $i);
            $building->setNumberOfAppartment(rand(100, 150));
            $building->setAddress($i . " Đại lộ Mai Chí Thọ, P.An Phú, Q.2");
            $manager->persist($building);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['building'];
    }
}