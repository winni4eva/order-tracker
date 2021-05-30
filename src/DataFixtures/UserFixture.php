<?php

namespace App\DataFixtures;

use App\Entity\User;
use BaseFixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends BaseFixture
{
    protected $roles = ['PICKER', 'SHIPPER', 'MANAGER'];

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'main_users', function($i){
            $user = new User();
            $index = $i + 1;
            $user->setEmail(sprintf('test%d@example.com', $index));
            $user->setFirstName($this->faker->firstName);
            $user->setLastName($this->faker->lastName);
            $user->setRole($this->roles[rand(0,2)]);

            return $user;
        });

        $manager->flush();
    }
}
