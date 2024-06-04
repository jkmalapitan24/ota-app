<?php

namespace App\Services;

use App\Jobs\SendEmailJob;
use App\Repositories\JobRepository;
use Illuminate\Support\Facades\Log;

class JobService
{
    private $jobRepository;

    public function __construct(
        JobRepository $jobRepository,
    ) {
        $this->jobRepository = $jobRepository;
    }

    public function store($requestData)
    {
        try {
            $emailExist = $this->jobRepository->getJobByEmail($requestData['email']);
            $job = $this->jobRepository->create($requestData);
            print_r($emailExist);
            if (!empty($job)) {
                if (empty($emailExist)) {
                    $this->sendJobEmail($requestData['title'], $requestData['description'], $job->id);
                }

                return $job;
            }
            return false;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function publishJob($id)
    {
        try {
            $job = $this->jobRepository->findJob($id);

            if (!empty($job)) {

                $job->is_published = 1;
                $job->save();

                return $job;
            }
            return false;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function spamJob($id)
    {
        try {
            $job = $this->jobRepository->findJob($id);
            if (!empty($job)) {
                $job->is_spam = 1;
                $job->save();
                return $job;
            }
            return false;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function showJob($id)
    {
        try {
            $job = $this->jobRepository->findJob($id);
            return $job;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function getAllPublishAndExternalJobs()
    {
        try {
            $data = [
                'published_jobs' => $this->jobRepository->getAllPublishedJobs(),
                'external_jobs' => $this->getExternalJob()
            ];
            return $data;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }

        // getAllPublishedJobs
    }

    public function getExternalJob()
    {
        $url = "https://mrge-group-gmbh.jobs.personio.de/xml";
        $fileContents = file_get_contents($url);
        $fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);
        $fileContents = trim(str_replace('"', "'", $fileContents));
        $simpleXml = simplexml_load_string($fileContents);
        $json = json_encode($simpleXml);
        $array = json_decode($json, TRUE);
        return $array;
    }

    private function sendJobEmail(String $title, String $description, String $id)
    {
        $moderatorEmail = env('MODERATOR_EMAIL');
        $publishLink = env('APP_URL') . "/api/job/publish/$id";
        $spamLink = env('APP_URL') . "/api/job/spam/$id";
        $mailData = [
            'moderatorEmail' => $moderatorEmail,
            'title' => $title,
            'description' => $description,
            'publishUrl' => $publishLink,
            'spamUrl' => $spamLink

        ];
        SendEmailJob::dispatch($mailData);
    }
}
