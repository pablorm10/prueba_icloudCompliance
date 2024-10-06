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

    public function index()
    {

        $documents = $this->documentService->paginateDocument(env('NUMBER_DOCUMENTS_PER_PAGE_PAGINATION'));

        // Pasar los documentos a la vista
        return view('documents.index', compact('documents'));
    }

    public function show($id)
    {
        // Obtener el documento por su ID
        $document = Document::findOrFail($id);

        // Si el documento tiene el archivo en base64 (asumiendo que está en un campo 'file_base64')
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
        // Validar los datos recibidos
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|max:1000',
            'document_file' => 'nullable|file|mimes:pdf', // Si se va a actualizar el archivo PDF
        ]);

        $dataRequest = $request->only(['title', 'description', 'content', 'relevance_id', 'approval_status']);
        $dataRequest['id']=$id;

        // if(!empty('document')){
        //     $file = $request->file('document');

        //     // Obtener el contenido del archivo en formato binario

        //     $fileContent = file_get_contents($file->getRealPath());

        //     // Convertir a base64
        //     $base64 = base64_encode($fileContent);

        //     $dataRequest['document']=$base64;
        // }


        $responseService = $this->documentService->updateDocumentByRequest($dataRequest);

         // Redirigir con mensaje de éxito
        return redirect()->route('documents.index')->with('success', 'Documento actualizado con éxito.');
    }


    public function destroy($id)
    {
        // Encontrar el documento
        $document = Document::findOrFail($id);

        // Eliminar el documento
        $document->delete();

        // Redirigir al listado de documentos con un mensaje de éxito
        return redirect()->route('documents.index')->with('success', 'Documento eliminado con éxito.');
    }

    public function create()
    {
        $relevances = RelevanceDocument::all();
        return view('documents.create', compact('relevances'));
    }

    public function store(Request $request)
    {
        // 1. Validar los datos del formulario
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
        // 4. Redirigir o devolver una respuesta
        return redirect()->route('documents.index')->with('success', 'Documento creado correctamente.');
    }



    public function showChart()
    {
        // Obtener la cantidad de documentos agrupados por relevancia
        $documentosCountsRelevancia = $this->documentService->getDocumentsGroupedByRelevance();
        $totalDocumentos=count($this->documentService->getDocuments());
        // Prepara los datos para el gráfico
        $labels = [];
        $data = [];


        foreach ($documentosCountsRelevancia as $doc) {
            $labels[] = $doc->relevance->relevance_level;
            $data[] = $doc->total;
        }

        // Pasar los datos a la vista, ya convertidos en JSON
        return view('grafico1', [
            'total' => $totalDocumentos,
            'labels' => json_encode($labels),  // Los pasamos como JSON
            'data' => json_encode($data)
        ]);
    }

    public function showChartDocumentsApprovedPerMonth(){


        $arrayApprovedDocument= $this->documentService->organizeDocumentsApprovedPerMonth();

        $labels = array_keys($arrayApprovedDocument['dataPerMonth']);  // Etiquetas (Meses)
        $data = array_values($arrayApprovedDocument['dataPerMonth']);  // Datos (Documentos aprobados por mes)

        // Pasamos los datos a la vista
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
