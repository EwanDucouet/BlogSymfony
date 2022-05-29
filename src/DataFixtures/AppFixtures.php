<?php

namespace App\DataFixtures;

use App\Factory\ArticleFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        UserFactory::createOne([
            'email' => 'admintest@test.com',
            'roles' => ['ROLE_ADMIN'],
            'username' => 'admintest'
        ]);
        UserFactory::createOne([
            'email' => 'usertest@test.com',
            'roles' => ['ROLE_USER'],
            'username' => 'usertest'
        ]);
        UserFactory::createMany(10);

        ArticleFactory::createMany(10);

        $manager->flush();
    }
}
