<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Parameter;
use App\Models\IndicatorFile;
use LaravelFileViewer;

class IndicatorFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($indicator_id, $parameter_id)
    {
        //
        $files = indicatorFile::select()->where('parameter_id', $parameter_id)->where('indicator_id', $indicator_id)->get();
        $parameter = Parameter::select()->where('id', $parameter_id)->first();
        return view('area chair.view_files_indicator')->with('parameter', $parameter)->with('indicator_id', $indicator_id)->with('parameter_id', $parameter_id)->with('files', $files);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $uid = Auth::id();
        $rules = [
            'files' => 'required',
            'parameter_id' => 'required', // Add validation for parameter_id
            'indicator_id' => 'required', // Add validation for indicator_id
        ];

        $customMessage = [
            'required' => 'Please select a file to upload.',
        ];

        $this->validate($request, $rules, $customMessage);

        $parameter_id = $request->input('parameter_id');
        $indicator_id = $request->input('indicator_id');
        $files = $request->file('files');

        foreach ($files as $file) {
            $indicatorFile = new IndicatorFile(); // Create a new instance for each file
            $fileName = $file->getClientOriginalName();
            $fileExtension = $file->getClientOriginalExtension();

            // Store the file and set attributes
            if ($file->storeAs('public/files/', $fileName)) {
                $indicatorFile->user_id = $uid;
                $indicatorFile->parameter_id = $parameter_id;
                $indicatorFile->indicator_id = $indicator_id;
                $indicatorFile->file_name = $fileName;
                $indicatorFile->file_type = $fileExtension;
                $indicatorFile->file_location = 'storage/files/'.$fileName;

                // Save the record to the database
                try {
                    // Save the record to the database
                    $indicatorFile->save();
                } catch (\Exception $e) {
                    // Handle the database error, e.g., log or return an error response
                    // Log the error message for debugging
                    \Log::error('Database error: ' . $e->getMessage());
                    // Return an error response, if necessary
                    return redirect()->back()->withErrors(['error' => 'Database error']);
                }
            }
        }

        if (count($files) > 0) {
            // Files were uploaded successfully
            session()->flash('success', 'File/s added successfully.');
        } else {
            // No files were uploaded
            session()->flash('error', 'Please select files to upload.');
        }

        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $file = IndicatorFile::find($id);
        if (!$file) {
            return abort(404);
        }
        $filename=$file->file_name;
        $filepath=$file->file_location;
        $file_url=asset($file->file_location);
        $file_data=[
          [
            'label' => __('Label'),
            'value' => "Value"
          ]
        ];

        //return LaravelFileViewer::show($filename, $filepath, $file_url, $file_data);
        return view('area chair.view_indicator_file')->with('file', $file);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
