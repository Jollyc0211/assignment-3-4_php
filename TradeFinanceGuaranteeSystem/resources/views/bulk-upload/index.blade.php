@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Uploaded Files</h2>

    <!-- Success and error messages -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- Table displaying uploaded files -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>File Name</th>
                <th>Upload Date</th>
                <th>File Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($uploadedFiles as $file)
                <tr>
                    <td>{{ $file->file_name }}</td>
                    <td>{{ $file->created_at }}</td>
                    <td>{{ $file->file_type }}</td>
                    <td>
                        <!-- Button to trigger file deletion confirmation -->
                        <form action="{{ route('bulk-upload.delete', $file->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this file?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
