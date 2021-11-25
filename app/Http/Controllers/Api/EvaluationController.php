<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEvaluationRequest;
use App\Http\Resources\EvaluationResource;
use App\Jobs\EvaluationCreatedJob;
use App\Models\Evaluation;
use App\Services\CompanyService;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{

    protected $companyService;
    protected $repository;

    /**
     * @param $repository
     */
    public function __construct(Evaluation $repository, CompanyService $companyService)
    {
        $this->companyService = $companyService;
        $this->repository = $repository;
    }


    public function index($company) {
        $evaluations = $this->repository->where('company', $company)->get();

        $data = array(
            'success' => true,
            'message' => 'Sucesso ao buscar avaliações',
            'data' => [
                'evaluations' => EvaluationResource::collection($evaluations)
            ]
        );

        return response()->json($data);
    }

    public function store(StoreEvaluationRequest $request, $company) {

        $response = $this->companyService->getCompany($company);
        $status = $response->status();
        if ($status != 200) {
            return response()->json([
                'success' => true,
                'message' => 'Falha ao buscar empresa'
            ], $status);
        }

        $company = json_decode($response->body());

        $evaluation = $this->repository->create($request->validated());

        EvaluationCreatedJob::dispatch($company->data->email)->onQueue('queue_email');

        return new EvaluationResource($evaluation);
    }
}
