<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Episode Details</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { text-align: center; }
        p { margin: 5px 0; }
        .container { width: 80%; margin: auto; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Deleted Episode Details</h1>
        <p><strong>Id:</strong> {{ $episode->id }}</p>
        <p><strong>Title:</strong> {{ $episode->title }}</p>
        <p><strong>Description:</strong> {{ $episode->episode_description ?? 'N/A' }}</p>
        <p><strong>Type:</strong> {{ $episode->type }}</p>
        <p><strong>Series:</strong> {{ $seriesName ?? 'N/A' }}</p>
        <p><strong>Season:</strong> {{ $SeasonName ?? 'N/A' }}</p>
        <p><strong>Deleted By:</strong> {{ $user->username ?? $user->name }}</p>
        <p><strong>Deleted User Id:</strong> {{ $user->id }}</p>
        <p><strong>Deleted At:</strong> {{ now() }}</p>
    </div>
</body>
</html>
