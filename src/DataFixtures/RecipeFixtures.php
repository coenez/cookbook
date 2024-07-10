<?php

namespace App\DataFixtures;

use App\Entity\Recipe;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use \Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class RecipeFixtures extends Fixture implements DependentFixtureInterface
{
    protected Faker\Generator $faker;

    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly CategoryRepository $categoryRepository
    ){}

    /**
     * Posts are dependent on user presence since a post is created by a user.
     * @return array
     */
    public function getDependencies(): array
    {
        return [UserFixtures::class, CategoryFixtures::class, IngredientFixtures::class, LabelFixtures::class];
    }

    public function load(ObjectManager $manager): void
    {
        $users = $this->userRepository->findAll();
        $categories = $this->categoryRepository->findAll();
        $this->faker = Faker\Factory::create();

        for($i = 0; $i < $this->faker->numberBetween(10, 20); $i++) {
            $title = $this->faker->word();
            $recipe = new Recipe();
            $recipe->setName($title);
            $recipe->setCategory($this->faker->randomElement($categories));
            $recipe->setPreparation($this->faker->text(500));
            $recipe->setDuration($this->faker->numberBetween(15, 120));
            $recipe->setPortions($this->faker->numberBetween(2, 8));
//            $recipe->setAuthor($users[array_rand($users)]);
            $recipe->setCreated($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $manager->persist($recipe);
        }

        $manager->flush();
    }
}
