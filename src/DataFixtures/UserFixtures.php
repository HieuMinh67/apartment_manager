<?php


namespace App\DataFixtures;


use App\Entity\Citizen;
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
        $user = new User();
        $user->setEmail("admin");
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setPassword($this->encoder->encodePassword($user, 'Admin@123'));
        $user->setPhone("+84989190190");
        $user->setFirstName("Hieu");
        $user->setLastName("Pham");
        $manager->persist($user);

        $csv = fopen(dirname(__FILE__) . '/data.csv', 'r');
        $i = 0;
        $gender = ['female', 'male'];
        $min = strtotime('47 years ago');
        $max = strtotime('18 years ago');
        $rand_time = mt_rand($min, $max);
        while ($line = fgetcsv($csv, 203, "|")) {
            $citizen[$i] = new Citizen();
            $citizen[$i]->setFirstName($line[2]);
            $citizen[$i]->setLastName($line[1]);
            $citizen[$i]->setPhone($line[0]);
            $citizen[$i]->setGender(array_rand($gender, 1));
            $citizen[$i]->setDateOfBirth(\DateTime::createFromFormat('Y-m-d', date('Y-m-d', $rand_time)));
            $manager->persist($citizen[$i]);

            $this->addReference("new Citizen-" . $i, $citizen[$i]);
            $i = $i + 1;
        }
        fclose($csv);

        $manager->flush();
    }
}