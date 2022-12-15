<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Script;

class UploadController extends Controller
{
    
    
    public function __invoke(Request $request){


        //check da file for safety/file types


        //create da file
        //get da file name
        $thumbnail = Storage::put($request->file('thumbnail')->hashName(), $request->thumbnail);
        //store in database
        Script::create([
            'title'=>$request->title,
            'outline'=>$request->outline,
            'thumbnail'=>$thumbnail
        ]);

        //put file to storage


        //return 


        return "";

    }
}
