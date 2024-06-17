<!DOCTYPE html>
<html>
<head>
    <title>Upload CSV</title>
</head>
<body>
    <form action="{{ URL::to('admin/episode/upload-csv-episodeslug') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="csv_file" required>
        <button type="submit">Upload</button>
    </form>
</body>
</html>
