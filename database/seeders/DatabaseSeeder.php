<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Demo password shared by every seeded account.
     */
    private const DEMO_PASSWORD = 'demo2026';

    /**
     * Seed demo accounts (all activated) and the current month's work days.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Ewa Kowalczyk',
            'email' => 'admin@firma-xyz.test',
            'role' => Role::Admin,
            'password' => self::DEMO_PASSWORD,
        ]);

        $supervisor = User::factory()->create([
            'name' => 'Tomasz Lewandowski',
            'email' => 'przelozony@firma-xyz.test',
            'role' => Role::Supervisor,
            'password' => self::DEMO_PASSWORD,
        ]);

        $employees = collect([
            ['Anna Nowak', 'a.nowak@firma-xyz.test'],
            ['Piotr Wiśniewski', 'p.wisniewski@firma-xyz.test'],
            ['Katarzyna Zielińska', 'k.zielinska@firma-xyz.test'],
        ])->map(fn (array $person): User => User::factory()->create([
            'name' => $person[0],
            'email' => $person[1],
            'role' => Role::Employee,
            'password' => self::DEMO_PASSWORD,
        ]));

        // Weekdays of the current month up to yesterday.
        $days = collect(CarbonPeriod::create(now()->startOfMonth(), now()->subDay()))
            ->filter(fn ($day) => $day->isWeekday());

        foreach ($employees as $employee) {
            foreach ($days as $day) {
                $employee->workDays()->create([
                    'date' => $day->toDateString(),
                    'hours' => fake()->randomElement([6, 7.5, 8, 8, 8, 8, 8.5, 10]),
                    'updated_by' => $supervisor->id,
                ]);
            }
        }

        $firstDay = $employees[0]->workDays()->orderBy('date')->first();

        $firstDay?->comments()->createMany([
            ['content' => 'Wpisane na podstawie listy obecności z recepcji.', 'created_by' => $supervisor->id],
            ['content' => 'Od 15:00 pracowałam zdalnie, liczba godzin się zgadza.', 'created_by' => $employees[0]->id],
        ]);

        $employees[1]->workDays()->orderByDesc('date')->first()?->comments()->create([
            'content' => 'Proszę o potwierdzenie godziny wyjścia.',
            'created_by' => $supervisor->id,
        ]);
    }
}
