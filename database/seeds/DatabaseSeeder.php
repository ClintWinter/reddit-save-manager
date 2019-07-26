<?php

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
        factory(Type::class)->create([
            'type' => 'comment'
        ]);
        factory(Type::class)->create([
            'type' => 'link'
        ]);
        factory(Type::class)->create([
            'type' => 'text'
        ]);
    }
}
