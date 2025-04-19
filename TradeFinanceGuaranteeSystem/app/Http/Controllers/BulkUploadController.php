<?php

namespace App\Http\Controllers;

use App\Models\Guarantee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Repositories\GuaranteeRepository;
use Illuminate\Support\Facades\DB;

class BulkUploadController extends Controller
{
    protected $guaranteeRepository;

    public function __construct(GuaranteeRepository $guaranteeRepository)
    {
        $this->guaranteeRepository = $guaranteeRepository;
    }

    // Show the bulk upload form
    public function showForm()
    {
        return view('bulk_upload');
    }

    // Handle file upload and data insertion
    public function uploadFile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:csv,xml,json|max:10240', // Validate file type and size
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $file = $request->file('file');
        $path = $file->storeAs('uploads', $file->getClientOriginalName()); // Store the file

        // Parse the file based on its extension
        $extension = $file->getClientOriginalExtension();
        $data = $this->parseFile($path, $extension);

        if ($data) {
            // Begin database transaction for bulk data insertion
            DB::beginTransaction();

            try {
                foreach ($data as $item) {
                    // Use GuaranteeRepository to save each record
                    $this->guaranteeRepository->createOrUpdate($item);
                }

                DB::commit();
                return redirect()->route('bulk-upload.index')->with('success', 'Data uploaded and processed successfully!');
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->withErrors(['file' => 'An error occurred while processing the file.']);
            }
        }

        return back()->withErrors(['file' => 'Failed to parse the file.']);
    }

    // Function to parse the file based on extension
    private function parseFile($filePath, $extension)
    {
        switch ($extension) {
            case 'csv':
                return $this->parseCSV($filePath);
            case 'json':
                return $this->parseJSON($filePath);
            case 'xml':
                return $this->parseXML($filePath);
            default:
                return false;
        }
    }

    // Parse CSV files
    private function parseCSV($filePath)
    {
        $file = fopen(storage_path('app/' . $filePath), 'r');
        $data = [];
        $header = fgetcsv($file); // Get header row

        while ($row = fgetcsv($file)) {
            $data[] = array_combine($header, $row);
        }
        fclose($file);

        return $data;
    }

    // Parse JSON files
    private function parseJSON($filePath)
    {
        $json = file_get_contents(storage_path('app/' . $filePath));
        return json_decode($json, true);
    }

    // Parse XML files
    private function parseXML($filePath)
    {
        $xml = simplexml_load_file(storage_path('app/' . $filePath));
        $json = json_encode($xml);
        return json_decode($json, true);
    }

    // Function to list all uploaded files
    public function listUploadedFiles()
    {
        // Retrieve all uploaded files from storage (could store details in DB for persistent access)
        $files = Storage::files('uploads');
        return view('bulk-upload.index', compact('files'));
    }

    // Delete uploaded file
    public function deleteFile($filename)
    {
        if (Storage::exists('uploads/' . $filename)) {
            Storage::delete('uploads/' . $filename);
            return back()->with('success', 'File deleted successfully!');
        }

        return back()->withErrors(['file' => 'File not found.']);
    }
}
