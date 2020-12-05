<?php


namespace App\DataFixtures;


use App\Entity\Apartment;
use App\Entity\Citizen;
use App\Entity\Employee;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;
    private $repo;

    public function __construct(UserPasswordEncoderInterface $encoder, EntityManagerInterface $em)
    {
        $this->encoder = $encoder;
        $this->repo = $em->getRepository(Apartment::class);
    }

    public function load(ObjectManager $manager)
    {
        $roles = ['ROLE_ADMIN', 'ROLE_MANAGER', 'ROLE_MANAGER', 'ROLE_STAFF', 'ROLE_STAFF', 'ROLE_STAFF'];
        $firstName = ["Hieu", "Jake", "Noah", "James", "Jack", "Connor"];
        $lastName = ["Pham", "John", "Harry", "Callum", "Mason", "Robert"];
        $email = ["admin@novaland.com", 'manager1@novaland.com', 'manager2@novaland.com', 'staff1@novaland.com', 'staff2@novaland.com', 'staff3@novaland.com'];
        for ($i = 0; $i < 6; $i++) {
            $employee = new Employee();
            $employee->setPhone("+849".strval(rand(10000000,99999999)));
            $employee->setFirstName($firstName[$i]);
            $employee->setLastName($lastName[$i]);
            $user = new User();
            $user->setEmail($email[$i]);
            $user->setRoles([$roles[$i]]);
            $user->setEmployee($employee);
            $manager->persist($user);
            $manager->persist($employee);
        }

        $csv = fopen(dirname(__FILE__) . '/data.csv', 'r');
        $i = 0;
        $gender = ['female', 'male'];
        $min = strtotime('85 years ago');
        $max = strtotime('5 years ago');
        $apartments = $this->repo->findAll();
        while ($line = fgetcsv($csv, 203, "|")) {
            $rand_time = mt_rand($min, $max);
            $citizen[$i] = new Citizen();
            $citizen[$i]->setFirstName($line[2]);
            $citizen[$i]->setLastName($line[1]);
            $citizen[$i]->setPhone($line[0]);
            $citizen[$i]->setGender(array_rand($gender, 1));
            $citizen[$i]->setDateOfBirth(\DateTime::createFromFormat('Y-m-d', date('Y-m-d', $rand_time)));
            $citizen[$i]->setApartmentId($apartments[array_rand($apartments, 1)]);
            $manager->persist($citizen[$i]);

            $this->addReference("new Citizen-" . $i, $citizen[$i]);
            $i = $i + 1;
        }
        fclose($csv);

        $manager->flush();
    }
}