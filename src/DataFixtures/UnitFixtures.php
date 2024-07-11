<?php

namespace App\DataFixtures;

use App\Entity\Unit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UnitFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            ['name' => 'Miligram', 'value' => 'mg'],
            ['name' => 'Gram', 'value' => 'gr'],
            ['name' => 'Eetlepel', 'value' => 'el'],
            ['name' => 'Theelepel', 'value' => 'tl'],
            ['name' => 'Mililiter', 'value' => 'ml'],
            ['name' => 'Stuks', 'value' => 'st'],
        ];
        foreach($data as $row) {
            $unit = new Unit();
            $unit->setName($row['name']);
            $unit->setValue($row['value']);
            $manager->persist($unit);
        }

        $manager->flush();
    }
}
