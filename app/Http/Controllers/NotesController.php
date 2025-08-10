<?php

namespace App\Http\Controllers;

use App\Models\files;
use App\Models\Notes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotesController extends Controller
{
    public function store(Request $request)
{
    // dd($request->all());
    $validator = Validator::make($request->all(), [
        'markdown_text' => 'required|string',
        'file_path.*' => 'file|max:5120' // allows multiple files
    ]);

    if ($validator->fails()) {
        return dd($validator->errors());
        // return response()->json([
        //     'errors' => $validator->errors()
        // ], 422);
    }

    $validation=$validator->validated();
    // dd($request->file('file_path'));
    $markdownText = $validation['markdown_text'];

    // Save note
    $note = Notes::create([
        'markdown_text' => $markdownText,
    ]);

  $files = $request->file('file_path');

    if (is_array($files)) {
    // multiple files
    foreach ($files as $file) {
        // process each file
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('uploads', $filename, 'public');

        $note->files()->create([
            'file_path' => $path,
        ]);
    }
    } elseif ($files) {
    // single file upload
    $filename = time() . '_' . $files->getClientOriginalName();
    $path = $files->storeAs('uploads', $filename, 'public');

    $note->files()->create([
        'file_path' => $path,
    ]);
    } else {
    return response()->json(['message'=>'no file uploaded']);
    }


    return response()->json([
        'message' => 'Note created successfully',
        'note' => $note->load('files')
    ], 201);
}


public function getData(Notes $note)
{
    dd($note->all());

}

}
