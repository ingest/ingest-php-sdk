<?php
/**
 * A series of tests to ensure proper functionality of the Ingest API and its SDK.
 *
 * The tests follow a consistent structure:
 * - instantiate the object
 * - call the method
 * - check the returned value against the expected value
 * - if not expected, notify
 *
 * Some tests depend on other tests having previously executed successfully, such as deleting a previously created resource.
 *
 * Some tests, such as Events, rely on the user providing test data, as it cannot be created.
 */

require dirname(__DIR__) . '/vendor/autoload.php';

use IngestPHPSDK\Jobs\Job;

$version = 'application/vnd.ingest.v1+json';
$token = ' ';

$job = new Job($version, $token);

$countingJobs = $job->count();

if($countingJobs["status"] != "HTTP/1.1 204 No Content")
{
  echo "Jobs could not be counted: \n";
  var_dump($countingJobs);
}

$gettingAllJobs = $job->getAll();

if($gettingAllJobs["status"] != "HTTP/1.1 200 OK")
{
  echo "Jobs could not be retrieved: \n";
  var_dump($gettingAllJobs);
}

$inputs = array('17577b37-7e31-428d-88be-64ebedb531e7', '73a9eedb-e9b7-4586-a8bf-24daa85202fb');
$video = 'dc606ed9-393f-4e2c-9675-5f918a0f8c94';
$profile = '3817a152-4248-4bf7-a5a8-25b89b51fd31';

$creatingAJob = $job->add($inputs, $video, $profile);

if($creatingAJob["status"] != "HTTP/1.1 201 Created")
{
  echo "Job could not be created: \n";
  var_dump($creatingAJob);
}
else
{
  $jobId = $creatingAJob["content"]->id;
}

if(isset($jobId))
{
  $gettingAllJobsById = $job->getById($jobId);

  if($gettingAllJobsById["status"] != "HTTP/1.1 200 OK")
  {
    echo "Job $jobId could not be retrieved: \n";
    var_dump($gettingAllJobsById);
  }

  $deletingAJob = $job->delete($jobId);

  if($deletingAJob["status"] != "HTTP/1.1 202 Accepted")
  {
    echo "Job $jobId could not be deleted: \n";
    var_dump($deletingAJob);
  }
}
else
{
  echo "Job tests were not conducted due to creation failure. \n";
}
