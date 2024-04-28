<?php

namespace Database\Seeders;

use App\Enums\Enums\SubscriptionType;
use App\Models\Subscription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subscription::create([
            'type' => SubscriptionType::STUDENT,
            'price' => 20,
        ]);
        Subscription::create([
            'type' => SubscriptionType::RESIDENT,
            'price' => 30,
        ]);
        Subscription::create([
            'type' => SubscriptionType::CONSULTANT,
            'price' => 70,
        ]);
        Subscription::create([
            'type' => SubscriptionType::NONEGYPTIAN,
            'price' => 100,
        ]);
    }
}
