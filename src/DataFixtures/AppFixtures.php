<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture 
{

    private $encoder; 


    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager)
    {

        $faker = \Faker\Factory::create('fr_FR'); 
        // $product = new Product();
        // $manager->persist($product);
        for ($u = 0; $u < 50 ; $u++)
        {
            $user = new User();

            $hash = $this->encoder->encodePassword($user, "11111111");
            
            $user->setFirstName($faker->firstName)
                    ->setLastName($faker->lastName)
                    ->setInscriptionAt($faker->dateTimeBetween('-30 years', 'now'))
                    ->setPhone($faker->phoneNumber)
                    ->setEmail($faker->email)
                    ->setPassword($hash);

                    $manager->persist($user);
                    


        }

        $manager->flush();
    }
}
