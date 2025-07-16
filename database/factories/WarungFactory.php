<?php

namespace Database\Factories;

use App\Models\Warung;
use Illuminate\Database\Eloquent\Factories\Factory;

class WarungFactory extends Factory
{
    protected $model = Warung::class;

    public function definition()
    {
        return [
            'nama_warung' => $this->faker->company(),
            'user_id' => \App\Models\User::factory(), // relasi ke user
        ];
    }
}
