<?php


namespace App\DataFixtures;


use App\Entity\Citizen;
use App\Entity\Employee;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $roles = ['ROLE_ADMIN', 'ROLE_MANAGER', 'ROLE_MANAGER', 'ROLE_STAFF', 'ROLE_STAFF', 'ROLE_STAFF'];
        $firstName = ["Hieu", "Jake", "Noah", "James", "Jack", "Connor"];
        $lastName = ["Pham", "John", "Harry", "Callum", "Mason", "Robert"];
        $email = ["admin@novaland.com", 'manager1@novaland.com', 'manager2@novaland.com', 'staff1@novaland.com', 'staff2@novaland.com', 'staff3@novaland.com'];
        for ($i = 0; $i < 6; $i++) {
            $employee = new Employee();
            $employee->setPhone("+84989190190");
            $employee->setFirstName($firstName[$i]);
            $employee->setLastName($lastName[$i]);
            $user = new User();
            $user->setEmail($email[$i]);
            $user->setRoles([$roles[$i]]);
            $user->setEmployee($employee);
            $manager->persist($user);
            $manager->persist($employee);
            $manager->flus();
        }

        $csv = fopen(dirname(__FILE__) . '/data.csv', 'r');
        $i = 0;
        $gender = ['female', 'male'];
        $min = strtotime('85 years ago');
        $max = strtotime('5 years ago');
        while ($line = fgetcsv($csv, 203, "|")) {
            $rand_time = mt_rand($min, $max);
            $citizen[$i] = new Citizen();
            $citizen[$i]->setFirstName($line[2]);
            $citizen[$i]->setLastName($line[1]);
            $citizen[$i]->setPhone($line[0]);
            $citizen[$i]->setGender(array_rand($gender, 1));
            $citizen[$i]->setDateOfBirth(\DateTime::createFromFormat('Y-m-d', date('Y-m-d', $rand_time)));
//            $citizen[$i]->set
//            $citizen[$i]->setApartmentId('');
            $manager->persist($citizen[$i]);

            $this->addReference("new Citizen-" . $i, $citizen[$i]);
            $i = $i + 1;
        }
        fclose($csv);

        $manager->flush();
    }
}