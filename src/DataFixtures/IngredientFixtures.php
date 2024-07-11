<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Repository\UnitRepository;
use Doctrine\Persistence\ObjectManager;
use \Doctrine\Common\DataFixtures\DependentFixtureInterface;

class IngredientFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private readonly UnitRepository $unitRepository,
    ){}

    public function getDependencies(): array
    {
        return [UnitFixtures::class];
    }

    public function load(ObjectManager $manager): void
    {
        $data = [
            ['name' => 'Aubergine'],
            ['name' => 'Ui'],
            ['name' => 'Bloem'],
            ['name' => 'Water'],
        ];

        $units = $this->unitRepository->findAll();

        foreach($data as $row) {
            $ingredient = new Ingredient();
            $ingredient->setName($row['name']);
//            $ingredient->setUnit($units[array_rand($units)]);
            $manager->persist($ingredient);
        }

        $manager->flush();
    }
}
