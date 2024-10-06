<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Services\DocumentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;


class DocumentControllerApi extends Controller
{

    protected $documentService;


    public function __construct(DocumentService $documentService)
    {
        $this->documentService = $documentService;
    }

    public function index()
    {
        $this->documentService->organizeDocumentsApprovedPerMonth();
        $response = $this->documentService->getDocumentsWithHiddenContent();
        return response()->json($response);
    }
}
