<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobStoreRequest;
use App\Services\JobService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use App\Models\Job;

class JobController extends Controller
{
    private $jobService;

    public function __construct(JobService $jobService)
    {
        $this->jobService = $jobService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = $this->jobService->getAllPublishAndExternalJobs();
        return view('jobs.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobStoreRequest $request)
    {
        try {
            $job = $this->jobService->store($request->validated());

            if ($job) {
                return response()->json([
                    'status' => 'success',
                    'data' => $job
                ], 201);
            }
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (\Exception $e) {
            report($e);
        }

        return response()->json([
            'status' => 'INTERNAL_SERVER_ERROR',
            'message' => 'Contact Administrator'
        ], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $job = $this->jobService->showJob($id);
        return view('jobs.show', compact('job'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function publishJob(int $id)
    {
        try {
            $job = $this->jobService->publishJob($id);
            if ($job) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Job published successfully',
                    'data' => $job
                ]);
            } else {
                return response()->json([
                    'message' => 'Job not found'
                ], 422);
            }
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (\Exception $e) {
            report($e);
        }
        return response()->json([
            'status' => 'INTERNAL_SERVER_ERROR',
            'message' => 'Contact Administrator'
        ], 500);
    }

    public function spamJob(string $id)
    {
        try {
            $job = $this->jobService->spamJob($id);

            if ($job) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Job successfully added to spam',
                    'data' => $job
                ]);
            } else {
                return response()->json([
                    'message' => 'Job not found'
                ], 422);
            }
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (\Exception $e) {
            report($e);
        }

        return response()->json([
            'status' => 'INTERNAL_SERVER_ERROR',
            'message' => 'Contact Administrator'
        ], 500);
    }
}
