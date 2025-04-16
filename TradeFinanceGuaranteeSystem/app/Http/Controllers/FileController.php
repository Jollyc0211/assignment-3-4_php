<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,json,xml|max:2048',
        ]);

        $path = $request->file('file')->store('uploads');
        return redirect()->back()->with('success', 'File uploaded successfully!');
    }

}
