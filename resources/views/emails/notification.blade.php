<!DOCTYPE html>
<html>

<head>
    <title>New Job : {{ $data['title'] }}</title>
</head>

<body>
    <div style="background-color:aliceblue; width:80%; border: 1px solid #000; min-height: 200px; text-align: center;">
        <table style="width:100%">
            <tr>
                <td colspan=2>
                    <h2>{{ $data['title'] }}</h2>
                </td>
            </tr>
            <tr>
                <td colspan=2>
                    <p>{{ $data['description'] }}</p>
                </td>
            </tr>
            <tr>
                <td>
                    <a href="{{ $data['publishUrl'] }}" target="_blank">Publish</a>
                </td>
                <td>
                    <a href="{{ $data['spamUrl'] }}" target="_blank">Spam</a>
                </td>
            </tr>
        </table>


    </div>

</body>

</html>