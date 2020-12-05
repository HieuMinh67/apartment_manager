<?php


namespace App\DataFixtures;


use App\Entity\Apartment;
use App\Entity\Building;
use App\Entity\Quotation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class BuildingFixtures extends Fixture implements FixtureGroupInterface
{

    public static function getGroups(): array
    {
        return ['building'];
    }

    public function load(ObjectManager $manager)
    {
        $name = ["Jake", "Noah", "James", "Jack", "Connor", "Liam", "John", "Harry", "Callum", "Mason", "Robert", "Jacob", "Michael", "Charlie", "Kyle", "William", "Thomas", "Joe", "Ethan", "David", "George", "Reece", "Michael", "Richard", "Oscar", "Rhys", "Alexander", "Joseph", "James", "Charlie", "James", "Charles", "William", "Damian", "Daniel", "Thomas"];
        for ($i = 0; $i < 5; $i++) {
            $building = new Building();
            $building->setName("THE SUN AVENUE" . $i);
            $building->setNumberOfAppartment(rand(100, 150));
            $building->setAddress($i . " Đại lộ Mai Chí Thọ, P . An Phú, Q.2");
            $manager->persist($building);
            for ($k = 0; $k < $building->getNumberOfAppartment(); $k++) {
                $apartment = new Apartment();
                $apartment->setBuilding($building);
                $apartmentArea = rand(50,150);
                $apartment->setArea($apartmentArea);
                $apartment->setPrice($apartmentArea *0.38*100000000);
                 $manager->persist($apartment);
            }
            for ($j = 0; $j < 20; $j++) {
                $quote = new Quotation();
                $genName = array_rand($name, 2);
                $quote->setName($name[$genName[0]]. " " .$name[$genName[1]]);
                $quote->setPhone("0".strval(rand(10000000,99999999)));
                $quote->setEmail(strtolower($name[$genName[0]].$name[$genName[1]].strval(rand(10000,99999)).'@gmail.com'));
                $quote->setMessage(file_get_contents('http://loripsum.net/api/1/medium/plaintext'));
                $quote->setBuilding($building);
                $quote->setCreateAt(\DateTime::createFromFormat('Y-m-d', date('Y-m-d', rand(strtotime('yesterday'), strtotime('last year')))));
                $quote->setIsArchived(false);
                $manager->persist($quote);
            }
        }

        $manager->flush();
    }
}