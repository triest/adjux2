<?php

use Illuminate\Database\Seeder;

class EducationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('educations')->insert([
            'name' => 'Bachelor',
        ]);

        DB::table('educations')->insert([
            'name' => 'Master',
        ]);

        DB::table('educations')->insert([
            'name' => 'PhD',
        ]);

    }
}
