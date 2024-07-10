<?php
namespace App\Entity\Enum;
enum Unit: string
{
    case Piece = 'st';
    case Gram = 'gr';
    case Mililiter = 'ml';
    case Teaspoon = 'tl';
    case Tablespoon = 'el';
    case Cup = 'cp';

    public static function serialize(): array
    {
        $result = [];
        foreach(self::cases() as $unit) {
            $result[] = [
                'name' => $unit->name,
                'value' => $unit->value,
            ];
        }
        return $result;
    }
}