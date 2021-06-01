<?php

namespace App\DataFixtures;

use App\DataFixtures\BaseFixture;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends BaseFixture
{

    protected $roles = ['ROLE_PICKER', 'ROLE_SHIPPER', 'ROLE_MANAGER'];

    protected $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder) 
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(3, 'shippers', function($i){
            $user = new User();
            $index = $i + 1;
            $role = $this->roles[rand(0,2)];
            $user->setEmail(sprintf('shipper%d@example.com', $index));
            $user->setFirstName($this->faker->firstName);
            $user->setLastName($this->faker->lastName);
            $user->setRoles(['ROLE_SHIPPER']);
            $user->setRole('ROLE_SHIPPER');
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'secret'
            ));

            return $user;
        });

        $this->createMany(3, 'pickers', function($i){
            $user = new User();
            $index = $i + 1;
            $role = $this->roles[rand(0,2)];
            $user->setEmail(sprintf('picker%d@example.com', $index));
            $user->setFirstName($this->faker->firstName);
            $user->setLastName($this->faker->lastName);
            $user->setRoles(['ROLE_PICKER']);
            $user->setRole('ROLE_PICKER');
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'secret'
            ));

            return $user;
        });

        $this->createMany(3, 'managers', function($i){
            $user = new User();
            $index = $i + 1;
            $user->setEmail(sprintf('manager%d@example.com', $index));
            $user->setFirstName($this->faker->firstName);
            $user->setLastName($this->faker->lastName);
            $user->setRoles(['ROLE_MANAGER']);
            $user->setRole('ROLE_MANAGER');
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'secret'
            ));

            return $user;
        });

        $manager->flush();
    }
}
