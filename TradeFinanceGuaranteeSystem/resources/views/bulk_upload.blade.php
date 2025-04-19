<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulk Upload Guarantees</title>
</head>
<body>
    <h2>Upload Guarantees</h2>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li style="color: red;">{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('bulk-upload.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="file">Choose file to upload (CSV, JSON, XML):</label>
        <input type="file" name="file" required>
        <button type="submit">Upload</button>
    </form>

    <h3>Uploaded Files</h3>
    <ul>
        @foreach(Storage::files('uploads') as $file)
            <li>
                <a href="{{ Storage::url($file) }}" target="_blank">{{ $file }}</a> 
                - <form action="{{ route('bulk-upload.delete', basename($file)) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
</body>
</html>
