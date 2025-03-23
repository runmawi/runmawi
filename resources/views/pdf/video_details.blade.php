<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>video Details</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { text-align: center; }
        p { margin: 5px 0; }
        .container { width: 80%; margin: auto; }
    </style>
</head>
<body>
    <div class="container">
        <h3>Deleted video Details</h3>
        <table border="1" width="100%" cellpadding="10" cellspacing="0" style="border-collapse: collapse; text-align: left;">
            <tr>
                <th style="width: 30%;">Field</th>
                <th style="width: 70%;">Details</th>
            </tr>
            <tr>
                <td><strong>Id</strong></td>
                <td>{{ $video->id }}</td>
            </tr>
            <tr>
                <td><strong>Title</strong></td>
                <td>{{ $video->title ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>Description</strong></td>
                <td>{{ $video->description ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>Type</strong></td>
                <td>{{ $video->type ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>Slug</strong></td>
                <td>{{ $video->slug ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>Mp4 Url</strong></td>
                <td>{{ $video->mp4_url ?? "N/A" }}</td>
            </tr>
            <tr>
                <td><strong>Deleted By</strong></td>
                <td>{{ $user->username ?? $user->name }}</td>
            </tr>
            <tr>
                <td><strong>Deleted User Id</strong></td>
                <td>{{ $user->id }}</td>
            </tr>
            <tr>
                <td><strong>Deleted At</strong></td>
                <td>{{ now() }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
