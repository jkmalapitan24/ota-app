<!DOCTYPE html>
<html>
<head>
    <title>Job Details</title>
</head>
<body>
    <h1>{{ $job->title }}</h1>
    <p>{{ $job->description }}</p>
    <a href="{{ route('jobs.index') }}">Back to Listings</a>
</body>
</html>
