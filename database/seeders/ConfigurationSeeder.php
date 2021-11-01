<?php

namespace Database\Seeders;

use App\Models\Configuration;
use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = array(
            array(
                'key' => 'api_key',
                'value' => null
            ),
        );

        foreach ($setting as $value) {
            $set = Configuration::updateOrCreate($value);
        }
    }
}
