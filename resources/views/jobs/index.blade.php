<!DOCTYPE html>
<html>

<head>
    <title>Job Listings</title>
    <style>
        html {
            font-family: Arial, Helvetica, sans-serif;
        }

        .td-border td {
            border: 1px solid #000;
        }
        .td-noborder td {
            border: 0;
        }
    </style>
</head>

<body>
    <h1>Job Listings</h1>
    <a href="{{ route('jobs.create') }}">Create New Job</a>
    <table style="width: 100%; margin-top: 50px;" class="td-border">
        @foreach ($jobs['published_jobs'] as $job)
        <tr>
            <td style="width: 30%;">
                <a href="{{ route('jobs.show', $job->id) }}">{{ $job->title }}</a>
            </td>
            <td style="width: 70%;">
                {{ $job->description }}
            </td>
        </tr>
        @endforeach


        @foreach ($jobs['external_jobs'] as $job)
        @foreach ($job as $jobRow)
        <tr>
            <td>
                {{ $jobRow['name'] }}
            </td>
            <td>
                <table style="width: 100%" class="td-noborder">
                    <tr>
                        <td>subcompany: </td>
                        <td>{{ $jobRow['subcompany'] }}</td>
                    </tr>
                    <tr>
                        <td>office: </td>
                        <td>{{ $jobRow['office'] }}</td>
                    </tr>
                    <tr>
                        <td>recruitingCategory: </td>
                        <td>{{ $jobRow['recruitingCategory'] }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        @endforeach
        @endforeach
    </table>
</body>

</html>