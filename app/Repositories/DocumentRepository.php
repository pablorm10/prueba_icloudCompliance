<?php

namespace App\Repositories;

use App\Models\Document;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;



class DocumentRepository
{


    public function getDocumentsGroupedByRelevance()
    {
        $documents = Document::with(['user:id,nick_name'])
        ->select(Config::get('documentConfig.columnas_getDocument')) // Obtener columnas desde la configuración
        ->get()
        ->makeHidden(['relevance','user_id'])
        ->groupBy(function ($document) {
            return $document->relevance->relevance_level;
        });

        return $documents;
    }

    public function getDocuments(){
        $documents = Document::all();

        return $documents;
    }


    public function getCountDocumentsGroupByRelevance(){
        $documentCounts = Document::with('relevance')
        ->select('relevance_id', \DB::raw('count(*) as total'))
        ->groupBy('relevance_id')
        ->get();

        return $documentCounts;
    }

    public function getDocumentById($id){
        // Encontrar el documento
        $document = Document::findOrFail($id);

        return $document;
    }

    public function updateDocument($dataUpdate){
        $documentUpdate =  Document::where('id', $dataUpdate['id'])->update($dataUpdate);

        return $documentUpdate;
    }

    public function getCampDocumentById($id, $camp){
        $response = Document::select($camp)->where('id', $id)->first();

        return $response;
    }

    public function createDocument($data){
        $newDocument = Document::create($data);

        return $newDocument->id;
    }

    public function getDocumentsPaginate($numberDocumentsPerPage){
        $documents = Document::orderBy('id', 'desc')->paginate($numberDocumentsPerPage);

        return $documents;
    }

    public function updateCampDocumentById($id, $camp, $value){
        $document = Document::where('id', $id)
            ->update([$camp => $value]); // Array asociativo

        return $document;
    }
}
