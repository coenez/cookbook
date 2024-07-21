<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class IngredientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            ['name' => 'Aubergine'],
            ['name' => 'Ui'],
            ['name' => 'Bloem'],
            ['name' => 'Water'],
        ];

        foreach($data as $row) {
            $ingredient = new Ingredient();
            $ingredient->setName($row['name']);
            $manager->persist($ingredient);
        }

        $manager->flush();
    }
}
