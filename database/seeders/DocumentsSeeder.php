<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Services\DateService;

class DocumentsSeeder extends Seeder
{

    protected $dateService;

    public function __construct(DateService $dateService)
    {
        $this->dateService = $dateService;
        $this->dateService = $dateService;
    }

    public function run(): void
    {

        for ($i = 1; $i <= env('NUMERO_DOCUMENTOS_SEEDERS'); $i++) {

            // Generar una fecha aleatoria
            $creationDateRandom = $this->dateService->generateRandomDate();
            $userID = rand(1, 3);
            $relevanceID = rand(1, 3);
            $randomAproval = rand(1, 2);

            if($randomAproval==1){
                $pdf= storage_path(env('RUTA_DOCUMENTO_PRUEBA_1'));
                $aprovalDate = $this->dateService->generateRandomDate();
            }else{
                $pdf= storage_path(env('RUTA_DOCUMENTO_PRUEBA_2'));
                $aprovalDate=null;
            }

            $documentoB64=base64_encode(File::get($pdf));



            DB::table('documents')->insert([
                'title' => 'documento_' . $i,
                'description' => 'Descripción del documento' . $i,
                'content' => $documentoB64, // Contenido del PDF codificado en Base64
                'user_id' => $userID,
                'relevance_id' => $relevanceID,
                'approval_date' => $aprovalDate,
                'creation_date' =>$creationDateRandom
            ]);
        }


    }
}
