<?php

use Illuminate\Database\Seeder;
use App\Models\Genre;

class GenresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genres = ['Terror','Comedy','Romance', 'Science Fiction','Drama','Documentary'];

        foreach ($genres as $key => $value) {
            $data = Genre::create([
                'name' => $value
            ]);
        }

    }
}
