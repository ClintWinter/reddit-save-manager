<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Type;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        Type::factory()->create([
            'type' => 'comment',
        ]);

        Type::factory()->create([
            'type' => 'link'
        ]);

        Type::factory()->create([
            'type' => 'text'
        ]);
    }
}
