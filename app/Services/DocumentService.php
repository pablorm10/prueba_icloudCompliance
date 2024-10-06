<?php

namespace App\Services;

use App\Repositories\DocumentRepository;
use App\Http\Responses\DocumentResponse;
use App\Models\User;
use Carbon\Carbon;

class DocumentService
{

    const DOCUMNET_COLUMNS = ['id', 'title', 'description', 'content', 'user_id', 'relevance_id', 'creation_date', 'approval_date', 'edition_date'];


    protected $documentRepository;
    protected $documentResponse;
    protected $dateService;


    public function __construct(DocumentRepository $documentRepository, DocumentResponse $documentResponse, DateService $dateService)
    {
        $this->documentRepository = $documentRepository;
        $this->documentResponse = $documentResponse;
        $this->dateService = $dateService;
    }

    /**
     * Obtener documentos agrupados por relevancia, ocultando el campo 'content'.
     *
     * @return array
     */
    public function getDocumentsWithHiddenContent()
    {
        $documents = $this->documentRepository->getDocumentsGroupedByRelevance();

        $documentsResponse = $this->documentResponse->buildResponseGetDocumentsGroup($documents);

        return $documentsResponse;
    }

    public function getDocuments(){
        $documents = $this->documentRepository->getDocuments();


        return $this->documentRepository->getDocuments();
    }

    public function getDocumentsGroupedByRelevance(){
        $documentsResponse = $this->documentRepository->getCountDocumentsGroupByRelevance();

        return $documentsResponse;
    }

    public function organizeDocumentsApprovedPerMonth(){

        $countNotApproved = 0;
        $countApproved=0;

        $arrayAprovved = [];
        $arrayDatesApproved = [];

        $allDocuments = $this->getDocuments();
        $totalDocuments = count($allDocuments);

        foreach ($allDocuments as $document) {
            if(empty($document['approval_date'])){
                $countNotApproved++;
            }else{
                array_push($arrayAprovved, $document['approval_date']);
                $countApproved++;
            }
        }

        $dataPerMonth = $this->getMonthToDocuments($arrayAprovved);

        $response = ['totalDocuments' => $totalDocuments,
                    'totalApproved' => $countApproved,
                    'totalNoApproved' => $countNotApproved,
                    'dataPerMonth'=> $dataPerMonth];

        return $response;

    }

    private function getMonthToDocuments($arrayDateDocuments){

        $arrayDates= [];
        $arrayMonths = $this->dateService::MONTHS_YEAR;

        foreach ($arrayMonths as $month => $numberMonth) {
            $countTotalMonth=0;
            // $arrayDates[$month]=$month
            foreach ($arrayDateDocuments as $dateDocument) {
                $monthDate=$this->dateService->getMonthToDate($dateDocument);

                if($monthDate==$numberMonth){
                    $countTotalMonth++;
                }
            }

            $arrayDates[$month]=$countTotalMonth;

        }

        return $arrayDates;
    }

    public function updateDocumentByRequest($dataRequest){

        $creationDateDcoument = $this->documentRepository->getCampDocumentById($dataRequest['id'], 'approval_date');

        if(!empty($dataRequest['approval_status']) && $dataRequest['approval_status']=='approved' && !empty($creationDateDcoument)){
            $dataRequest['approval_date'] = Carbon::now();
        }

        $dataRequest['edition_date']= Carbon::now();

        $dataUpdateDocument = $this->prepareDataToRepository($dataRequest);

        $responseUpdate = $this->documentRepository->updateDocument($dataUpdateDocument);

    }

    public function createNewDocument($data){

        if(!empty($data['approval_status']) && $data['approval_status']=='approved'){
            $data['approval_date'] = Carbon::now();
        }

        $data['creation_date'] = Carbon::now();

        $data['user_id']=auth()->user()->id;

        $dataNewDocument = $this->prepareDataToRepository($data);

        $idDocument = $this->documentRepository->createDocument($dataNewDocument);

        return $idDocument;
    }

    private function prepareDataToRepository($data){

        $arrayDataRepository = [];

        foreach ($this::DOCUMNET_COLUMNS as $column) {
            foreach ($data as $title => $value) {
               if($column==$title && !empty($value)){
                   $arrayDataRepository[$column]=$value;
               }
            }
       }

       return $arrayDataRepository;
    }


    public function paginateDocument($numberDocumentsPerPage){

        $ppppp = env('CAMP_APPROVAL_DATE');
        $documents = $this->documentRepository->getDocumentsPaginate($numberDocumentsPerPage);

        return $documents;
    }

    public function approveDocument($idDocument){

        $this->documentRepository->updateCampDocumentById($idDocument, env('CAMP_APPROVAL_DATE'), Carbon::now());
    }


}
