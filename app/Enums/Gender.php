<?php

declare(strict_types=1);

namespace App\Enums;

enum Gender: string
{
    case Male  = 'Male';
    case Female = 'Female';
    case Other = 'Other';
    case Unknown = 'Unknown';
    case None = 'None';

    /**
     * Get the values of the enum.
     *
     * @return array<string, string>
     */
    public static function toArray(): array
    {
        return [
            self::Male->value => 'Male',
            self::Female->value => 'Female',
            self::Other->value => 'Other',
            self::Unknown->value => 'Unknown',
            self::None->value => 'None',
        ];
    }
}