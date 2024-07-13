<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use App\Entity\Recipe;
use App\Entity\RecipeIngredient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Repository\IngredientRepository;
use App\Repository\RecipeRepository;
use Doctrine\Persistence\ObjectManager;
use \Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class RecipeIngredientFixtures extends Fixture implements DependentFixtureInterface
{
    protected Faker\Generator $faker;

    public function __construct(
        private readonly IngredientRepository $ingredientRepository,
        private readonly RecipeRepository $recipeRepository
    ){}

    public function getDependencies(): array
    {
        return [RecipeFixtures::class, IngredientFixtures::class];
    }

    public function load(ObjectManager $manager): void
    {
        $this->faker = Faker\Factory::create();

        $recipes = $this->recipeRepository->findAll();
        $ingredients = $this->ingredientRepository->findAll();

        foreach($recipes as $recipe) {
            for($i = 0; $i < $this->faker->numberBetween(5, 15); $i++) {
                $recipeIngredient = new RecipeIngredient();
                $recipeIngredient
                    ->setRecipe($recipe)
                    ->setIngredient($ingredients[array_rand($ingredients)])
                    ->setAmount($this->faker->numberBetween(1, 500));

                $manager->persist($recipeIngredient);
            }

        }

        $manager->flush();
    }
}
