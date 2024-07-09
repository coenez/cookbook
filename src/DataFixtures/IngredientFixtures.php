<?php

namespace App\DataFixtures;

use App\Entity\Enum\Unit;
use App\Entity\Ingredient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class IngredientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            ['name' => 'Aubergine', 'unit' => Unit::Piece],
            ['name' => 'Ui', 'unit' => Unit::Piece],
            ['name' => 'Bloem', 'unit' => Unit::Gram],
            ['name' => 'Water', 'unit' => Unit::Mililiter],
        ];
        foreach($data as $row) {
            $ingredient = new Ingredient();
            $ingredient->setName($row['name']);
            $ingredient->setUnit($row['unit']);
            $manager->persist($ingredient);
        }

        $manager->flush();
    }
}
