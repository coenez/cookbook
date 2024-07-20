<?php

namespace App\Serializer;

use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class RecipeIngredient {

    private Serializer $serializer;

    public function __construct()
    {
        $this->serializer = new Serializer([new ObjectNormalizer()]);
    }

    public function serialize(\App\Entity\RecipeIngredient $recipeIngredient)
    {
        $serialized = $this->serializer->normalize($recipeIngredient, null, [AbstractNormalizer::ATTRIBUTES => [
            'amount',
            'ingredient' => [
                'id',
                'name',
                'unit' => [
                    'name'
                ]
            ]
        ]
        ]);

        return [
            'id' => $serialized['ingredient']['id'],
            'name' => $serialized['ingredient']['name'],
            'unit' => $serialized['ingredient']['unit']['name'],
            'amount' => $serialized['amount']
        ];

    }
}