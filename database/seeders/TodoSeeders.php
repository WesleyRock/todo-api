<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Todo;

class TodoSeeders extends Seeder
{
    public function run(): void
    {
        Todo::factory()->count(10)->create();
    }
}
