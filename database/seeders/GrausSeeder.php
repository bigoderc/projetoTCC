<?php

namespace Database\Seeders;

use App\Models\Grau;
use Illuminate\Database\Seeder;

class GrausSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $graus = [
            'Graduação',
            'Especialização',
            'Mestrado',
            'Doutorado'
        ];

        foreach($graus as $key => $value){
            Grau::updateOrCreate(['nome'=>$value]);
        }
    }
}
