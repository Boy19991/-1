<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use App\Models\Script;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        //storage_path('app/public')
        $data = json_decode(Storage::disk('local')->get('scriptdata.txt'));
        //print_r($data);

        /*
            'number': row.values[1] || "",
            'broadcast_year':row.values[2] || "",
            'title':row.values[3] || "",
            'genre':row.values[4] || "",
        */
        //echo $data;
        $count = count($data);

        for ($i=1;$i<$count;$i++){
            //echo $data[$i]->title . '/\n';
            $mn = "";
            if ( gettype($data[$i]->management_number) !== "string") {
                $mn = "";
            } else {
                $mn = $data[$i]->management_number;
            }
            
            if ($data[$i]->number !== 69) {
                Script::create([
                    'number'=>$data[$i]->number,
                    'title'=>$data[$i]->title,
                    'broadcast_year'=>$data[$i]->broadcast_year,
                    'genre'=>$data[$i]->genre,
                    'continue'=>$data[$i]->continue,
                    'company'=>$data[$i]->company,
                    'script_writer'=>$data[$i]->script_writer,
                    'original_writer'=>$data[$i]->original_writer,
                    'original_name'=>$data[$i]->original_name,
                    'producer'=>$data[$i]->producer,
                    'performance'=>$data[$i]->performance,
                    'cast'=>$data[$i]->cast,
                    'outline'=>$data[$i]->outline,
                    'extra'=>$data[$i]->extra,
                    'owner'=>$data[$i]->owner,
                    'management_number'=>$mn,
                    'keyword'=>$data[$i]->keyword,
                    'image'=> '',
                    'file'=> '',
                ]);
            }
            //echo $data[$i]->number . " ";
            
            

            
            
        }



    }
}
