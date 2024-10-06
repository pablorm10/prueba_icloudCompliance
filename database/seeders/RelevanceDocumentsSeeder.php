<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;



class RelevanceDocumentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('relevance_documents')->insert([
            ['relevance_level' => 'Alta',
            'created_at' => Carbon::now()],
            ['relevance_level' => 'Media',
            'created_at' => Carbon::now()],
            ['relevance_level' => 'Baja',
            'created_at' => Carbon::now()],
        ]);
    }
}
