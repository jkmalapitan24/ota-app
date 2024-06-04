<?php

namespace App\Repositories;

use App\Models\Job;

class JobRepository
{
    protected $model;

    public function __construct(Job $model)
    {
        $this->model = $model;
    }
    public function findJob($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function getJobByEmail(string $email)
    {
        $job = $this->model->where('email', $email);

        return $job->first();
    }

    public function getAllPublishedJobs(){
        $jobs = $this->model->where('is_published', true);
        return $jobs->get();
    }
}
