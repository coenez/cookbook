<?php

namespace App\DataFixtures;

use App\Entity\Recipe;
use App\Repository\CategoryRepository;
use App\Repository\IngredientRepository;
use App\Repository\LabelRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use \Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class RecipeFixtures extends Fixture implements DependentFixtureInterface
{
    protected Faker\Generator $faker;

    public function __construct(
        private readonly CategoryRepository $categoryRepository,
        private readonly LabelRepository $labelRepository,
        private readonly UserRepository $userRepository,
    ){}

    public function getDependencies(): array
    {
        return [UserFixtures::class, CategoryFixtures::class, LabelFixtures::class];
    }

    public function load(ObjectManager $manager): void
    {
        $labels = $this->labelRepository->findAll();
        $categories = $this->categoryRepository->findAll();
        $users = $this->userRepository->findAll();

        $this->faker = Faker\Factory::create();

        for($i = 0; $i < $this->faker->numberBetween(20, 30); $i++) {
            $title = $this->faker->word();
            $recipe = new Recipe();
            $recipe->setName($title);
            $recipe->setUser($this->faker->randomElement($users));
            $recipe->setCategory($this->faker->randomElement($categories));
            $recipe->setPreparation($this->faker->text(500));
            $recipe->setDuration($this->faker->numberBetween(15, 120));
            $recipe->setPortions($this->faker->numberBetween(2, 8));

            for($j = 0; $j < $this->faker->numberBetween(1, 3); $j++) {
                $recipe->addLabel($labels[array_rand($labels)]);
            }
            $recipe->setCreated($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $manager->persist($recipe);
        }

        $manager->flush();
    }
}
