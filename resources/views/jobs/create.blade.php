<!DOCTYPE html>
<html>
<head>
    <title>Create Job</title>
    <style>
        html {
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>
<body>
    <h1>Create Job</h1>
    <form action="{{ route('jobs.store') }}" method="POST">
        @csrf
        <table style="width: 50%;">
            <tr>
                <td style="width: 20%"><label>Title:</label></td>
                <td style="width: 80%"><input type="text" name="title"></td>
            </tr>
            <tr>
                <td><label>Description:</label></td>
                <td><textarea name="description"></textarea></td>
            </tr>
            <tr>
                <td><label>Email:</label></td>
                <td><input type="email" name="email"></td>
            </tr>
            <tr>
                <td colspan="2">
                <button type="submit">Submit</button>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
