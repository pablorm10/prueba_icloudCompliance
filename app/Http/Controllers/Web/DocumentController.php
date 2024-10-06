<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\RelevanceDocument;
use App\Services\DocumentService;
use Carbon\Carbon;
use Illuminate\Http\Request;


class DocumentController extends Controller
{

    protected $documentService;


    public function __construct(DocumentService $documentService)
    {
        $this->documentService = $documentService;
    }

    public function index(Request $request)
    {
        $filterDate = $request->query('filterDate');
        $filterRelevance = $request->query('filterRelevance');

        $documents = $this->documentService->getDocumentsByFilters($filterDate, $filterRelevance);

        $relevances = RelevanceDocument::all();
        return view('documents.index', compact('documents', 'relevances'));
    }

    public function show($id)
    {

        $document = $this->documentService->getDocumentById($id);

        $base64PDF = $document->content;

        return view('documents.show', compact('document', 'base64PDF'));
    }

    public function edit($id)
    {
        $document = Document::findOrFail($id);

        $relevances = RelevanceDocument::all();
        return view('documents.edit', compact('document', 'relevances'));
    }

    public function update(Request $request, $id){

        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|max:1000',
            'document_file' => 'nullable|file|mimes:pdf', // Si se va a actualizar el archivo PDF
        ]);

        $dataRequest = $request->only(['title', 'description', 'content', 'relevance_id', 'approval_status']);
        $dataRequest['id']=$id;



        $responseService = $this->documentService->updateDocumentByRequest($dataRequest);


        return redirect()->route('documents.index')->with('success', 'Documento actualizado con éxito.');
    }


    public function destroy($id)
    {

        $responseService = $this->documentService->deleteDocument($id);

        return redirect()->route('documents.index')->with('success', 'Documento eliminado con éxito.');
    }

    public function create()
    {
        $relevances = RelevanceDocument::all();
        return view('documents.create', compact('relevances'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'relevance_id' => 'required|exists:relevance_documents,id',
            'document' => 'required|file|mimes:pdf|max:2048',
        ]);

        $dataRequest = $request->only(['title', 'description', 'content', 'relevance_id', 'approval_status']);

        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $dataRequest['content'] = base64_encode(file_get_contents($file));
        }

        $responseService = $this->documentService->createNewDocument($dataRequest);

        return redirect()->route('documents.index')->with('success', 'Documento creado correctamente.');
    }



    public function showChart()
    {
        $documentosCountsRelevancia = $this->documentService->getDocumentsGroupedByRelevance();
        $totalDocumentos=count($this->documentService->getDocuments());
        // Prepara los datos para el gráfico
        $labels = [];
        $data = [];


        foreach ($documentosCountsRelevancia as $doc) {
            $labels[] = $doc->relevance->relevance_level;
            $data[] = $doc->total;
        }

        return view('grafico1', [
            'total' => $totalDocumentos,
            'labels' => json_encode($labels),
            'data' => json_encode($data)
        ]);
    }

    public function showChartDocumentsApprovedPerMonth(){


        $arrayApprovedDocument= $this->documentService->organizeDocumentsApprovedPerMonth();

        $labels = array_keys($arrayApprovedDocument['dataPerMonth']);  // Etiquetas (Meses)
        $data = array_values($arrayApprovedDocument['dataPerMonth']);  // Datos (Documentos aprobados por mes)


        return view('grafico2', [
            'year' => Carbon::now()->year,
            'totalDocuments' => $arrayApprovedDocument['totalDocuments'],
            'totalApproved' => $arrayApprovedDocument['totalApproved'],
            'totalNoApproved' => $arrayApprovedDocument['totalNoApproved'],
            'labels' => json_encode($labels),
            'data' => json_encode($data),
        ]);

    }

    public function approveDocument($idDocument){
        $approvedDocument = $this->documentService->approveDocument($idDocument);

        return redirect()->route('documents.show', $idDocument)
        ->with('success', 'El documento ha sido actualizado correctamente.');
    }


}
