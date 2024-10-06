<?php

namespace App\Http\Responses;

class DocumentResponse
{
    public function buildResponseGetDocumentsGroup($documents)
    {
        $response = [
            'status' => 'ok',
            'data' => [],
        ];


        foreach ($documents as $relevance => $documentosRelevancia) {
            $prueba = count($documentosRelevancia);



            $response['data']['relevance'][$relevance]['count']=$prueba;
            $response['data']['relevance'][$relevance]['documents']=$documentosRelevancia;


        }

        return $response;

    }
}
