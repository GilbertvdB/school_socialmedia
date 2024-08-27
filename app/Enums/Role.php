<?php

declare(strict_types=1);

namespace App\Enums;

enum Role: string
{
    case None = 'None';
    case Admin = 'Admin';
    case Personel = 'Personel';
    case Teacher = 'Teacher';
    case Parent = 'Parent';
    case Student = 'Student';

    /**
     * Get the values of the enum.
     *
     * @return array<string, string>
     */
    public static function toArray(): array
    {
        return [
            self::None->value => 'None',
            self::Admin->value => 'Admin',
            self::Personel->value => 'Personel',
            self::Teacher->value => 'Teacher',
            self::Parent->value => 'Parent',
            self::Student->value => 'Student',
        ];
    }
}
