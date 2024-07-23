<?php

namespace App\Dto;

class RecipeDto extends AbstractDto {
    public ?int $id;
    public string $name;
    public object $category;
    public int $duration;
    public int $portions;
    public string $preparation;
    public array $labels;
    public array $recipeIngredients;
    public array $images;
}
