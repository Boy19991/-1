<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\ScriptsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Script;
use Inertia\Inertia;
use Intervention\Image\ImageManager;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    /*
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
    */
    return view('welcome');
});



//back-end
Route::resource('scripts', ScriptsController::class)->middleware(['auth', 'verified']);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

   // 
});


require __DIR__.'/auth.php';

Route::post('/upload', function (Request $request) {


    //defaults to storage/app
    //then... this adds /public/ making storage/app/public
    $manager = new ImageManager(['driver' => 'imagick']);

    if ($request->file){
       $path = $request->file('file')->store('','public');
    }
    
    //asset() //client side
    //storage() //server side
    $image = Image::make(storage_path('app/public/'.$path))
    ->resize(150,150, function ($constraint) {
		    $constraint->aspectRatio();
    });

    //$image->save(storage_path('app/public/150-'.$path));
    $image->save('150-'.$path);
    //Storage::put('150-'.$path, $image);
    
    return response()->json([
        'image' => $image->basename,
        'image_full_path' => URL::to('') .'/'.$image->basename,
    ]);

    //do a render?


})->name('upload');


/*
IN CASE
we need server to serve images, 
we may need a function here,
if images cannot be accessed by browser
Route::get('', function($id,$file_path){
    
    /*
    Check if it exists
    */
    /*
    $file = Storage::disk('public')->get($file_path);
    $path = 'storage/app/public/'.$file_path;
    //$file = File::get($path);
    *
    $path = storage_path('app/public/'.$file_path);

    if (!File::exists($path)) {
        return $path;
    }

    $file = File::get($path);
    //$response = Response::make($file, 200);
    return response($file)->header('Content-Type','image/png');
    

});
*/

