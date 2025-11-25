<?php

namespace App\Http\Controllers;

use App\Models\files;
use App\Models\Notes;
use App\Services\GrammerChecker;
use App\Services\MarkdownText as ServicesMarkdownText;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class NotesController extends Controller
{
    protected $markdownText;
    protected $grammerChecker;

    public function __construct(ServicesMarkdownText $markdownText,GrammerChecker $grammerChecker)
    {
        $this->markdownText=$markdownText;
        $this->grammerChecker=$grammerChecker;
        
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'markdown_text' => 'required|string',
            'file_path.*' => 'file|max:5120' 
        ]);

        if ($validator->fails()) {
            return dd($validator->errors());
            // return response()->json([
            //     'errors' => $validator->errors()
            // ], 422);
        }

        $validation = $validator->validated();
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
            return response()->json(['message' => 'no file uploaded']);
        }


        return response()->json([
            'message' => 'Note created successfully',
            'note' => $note->load('files')
        ], 201);
    }


    public function getData($id)
    {
        $data = Notes::with('files')->find($id);
        
        $markdownText = $data->markdown_text;
        $file = $data->files->pluck('file_path');



        return response()->json([
            'message' => 'data retrive successfully',
            'markdownText' => $markdownText,
            'files' => $file,
        ]);
    }


    public function renderText($id)
    {
        $data = Notes::with('files')->find($id);

        $text = $data->markdown_text;
        // $converter = new CommonMarkConverter();
        // $renderedText = (string) $converter->convert($markdownText);

        $renderedText=(string)  $this->markdownText->convert($text);
        
        return response()->json([
            'message'=>'succssfully rendered to html',
            'rendereText'=>$renderedText,
        ]);
    }

    public function checkGrammer($id){

        $data = Notes::find($id);

        if(!$data){
            return response()->json([
            'message'=>"data not found",
        ],404); 
        }

        $markdownText = $data->markdown_text;
       

        $checked=$this->grammerChecker->check($markdownText );

        return response()->json([
            'checked_data'=>$checked,
        ]);

        
    }


}
