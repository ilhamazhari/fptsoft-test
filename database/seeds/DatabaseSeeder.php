<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
          'name' => 'adminfpt',
          'email' => 'admin@localhost',
          'password' => bcrypt('fptTest@2020'),
          'api_token' => Str::random(60)
        ]);

        DB::table('Artists')->insert([
          'ArtistName' => 'Bring Me The Horizon',
          'AlbumName' => 'That\'s The Spirit',
          'ReleaseDate' => '2015-02-02',
          'Price' => 50000
        ]);
    }
}
