<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreScriptRequest;
use App\Models\Script;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;


class ScriptsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $scripts = Script::all();
        $path = asset('storage').'/';
        return inertia('Scripts/Index', [
            'scripts'=>$scripts,
            'path'=> URL::to('/').'/',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return Inertia::render('Scripts/Create', [
            'csrf_token' => csrf_token(),
            'path'=> asset('storage'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreScriptRequest $request)
    {
        //if (!$thumbnail) {} if it didn't work
        $result = Script::create([
            'title'=>$request->title,
            'outline'=>$request->outline,
            'image'=>$request->image,
        ]);

        $result = !$result ? 'error': 'Added successfully';
        return redirect()->route('scripts.index')
        ->with('message', $result);
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $script = Script::find($id);
        return inertia('Scripts/Edit', [
            'script' => $script,
            'path'=> URL::to('/').'/',
            'csrf_token' => csrf_token()
        ]);

        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $script = Script::where('id',$request->id)
            ->update([
                'title'=>$request->title,
                'outline'=>$request->outline,
                'image'=>$request->image,
                
            ]);
        //$result = !$result ? 'error': 'Deleted successfully';

        return redirect()->route('scripts.index')
        ->with('message', $request->id);

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
        $result = Script::where('id',$id)->delete();
        /*
        return Inertia::render('Scripts/Index', [
            'result'=>$result,
        ]);
        */
        $result = !$result ? 'error': 'Deleted successfully';

        return redirect()->route('scripts.index')
        ->with('message', $result);

    }
}


        
/*
        return Inertia::render('Dashboard', [
            'scripts' => Script::all(),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
        
        $scripts = ScriptResource::collection(Script::all());
        return inertia('Dashboard', compact('scripts'));

        /*
        return Inertia::render('Scripts/Create', [
            'result' => $result,
            //'pathToThumbnail' => asset('storage/' . $filename),
            //'pathToThumbnail' => $thumbnail,
            //'pathToThumbnail' => Storage::disk('public')->url($thumbnail)
        ]);
        */

        /*
        $request->validated();

        $thumbnail = $request->file('thumbnail')->store('public');
        $filename = $request->file('thumbnail')->hashName();
        */


