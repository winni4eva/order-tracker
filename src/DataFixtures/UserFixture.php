<?php

namespace App\DataFixtures;

use App\Entity\User;
use BaseFixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends BaseFixture
{

    protected $roles = ['PICKER', 'SHIPPER', 'MANAGER'];

    protected $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder) 
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'main_users', function($i){
            $user = new User();
            $index = $i + 1;
            $role = $this->roles[rand(0,2)];
            $user->setEmail(sprintf('test%d@example.com', $index));
            $user->setFirstName($this->faker->firstName);
            $user->setLastName($this->faker->lastName);
            $user->setRoles([$role]);
            $user->setRole($role);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'secret'
            ));

            return $user;
        });

        $manager->flush();
    }
}
