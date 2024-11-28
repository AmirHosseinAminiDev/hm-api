<?php

namespace App\Enum;

enum LevelEnum: int
{
    case LEVEL_ZERO = 0;
    case LEVEL_ONE = 1;
    case LEVEL_TWO = 2;
    case LEVEL_THREE = 3;
    case LEVEL_FOUR = 4;
    case LEVEL_FIVE = 5;
    case LEVEL_SIX = 6;
    case LEVEL_SEVEN = 7;
    case LEVEL_EIGHT = 8;
    case LEVEL_NINE = 9;
    case LEVEL_TEN = 10;
    case LEVEL_ELEVEN = 11;
    case LEVEL_TWELVE = 12;
    case LEVEL_THIRTEEN = 13;

    public static function getLevelEnumList(): array
    {
        return array_column(LevelEnum::cases(), 'value', 'name');
    }

    public static function getEnumValueByName(string $name): int
    {
        return LevelEnum::from($name)->value;
    }
}
