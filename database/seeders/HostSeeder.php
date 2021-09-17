<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Host;
use App\Models\Php;

class HostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $php = Php::where('default', true)->first();

        $php->hosts()->create([
            'domain' => 'localhost',
            'path'   => 'C:\xampp\htdocs',
        ]);
    }
}
