<?php

namespace App\DataFixtures;

use App\Entity\Label;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LabelFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            ['name' => 'Vegetarisch'],
            ['name' => 'Feest'],
            ['name' => 'Lactose'],
            ['name' => 'Glutenvrij'],
            ['name' => 'Noten'],
        ];
        foreach($data as $row) {
            $label = new Label();
            $label->setName($row['name']);
            $manager->persist($label);
        }

        $manager->flush();
    }
}