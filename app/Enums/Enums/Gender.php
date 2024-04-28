<?php

namespace App\Enums\Enums;

enum Gender: string
{
    case FEMALE = "female";
    case MALE = "male";
    case CUSTOM = "custom";

    // public static function toArray(): array
    // {
    //     return array_column(Gender::cases(), 'value');
    // }
}
