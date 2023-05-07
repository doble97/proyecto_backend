<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Language::create([
            'name'=>'English',
            'initials'=>'en'
        ]);
        Language::create([
            'name'=>'Spanish',
            'initials'=>'es'
        ]);
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> alexis
