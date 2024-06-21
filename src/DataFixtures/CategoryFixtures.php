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
            ['name' => 'Breakfast', 'slug' => 'breakfast'],
            ['name' => 'Lunch', 'slug' => 'lunch'],
            ['name' => 'Dinner', 'slug' => 'dinner'],
            ['name' => 'Desert', 'slug' => 'desert'],
        ];
        foreach($data as $row) {
            $category = new Category();
            $category->setName($row['name']);
            $category->setSlug($row['slug']);
            $manager->persist($category);
        }

        $manager->flush();
    }
}
