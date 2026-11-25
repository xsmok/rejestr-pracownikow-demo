<?php

namespace App\Enums;

enum Role: string
{
    case Admin = 'admin';
    case Supervisor = 'supervisor';
    case Employee = 'employee';

    /**
     * Polish name of the role shown in the interface.
     */
    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrator',
            self::Supervisor => 'Przełożony',
            self::Employee => 'Pracownik',
        };
    }

    /**
     * Name of the route the user lands on after logging in.
     */
    public function homeRoute(): string
    {
        return match ($this) {
            self::Admin => 'admin.users.index',
            self::Supervisor => 'summary',
            self::Employee => 'my-time',
        };
    }
}
