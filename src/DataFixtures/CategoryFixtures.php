<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            ['name' => 'Breakfast'],
            ['name' => 'Lunch'],
            ['name' => 'Dinner'],
            ['name' => 'Desert'],
            ['name' => 'Borrel'],
        ];
        foreach($data as $row) {
            $category = new Category();
            $category->setName($row['name']);
            $manager->persist($category);
        }

        $manager->flush();
    }
}
