<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post("/task", function (Request $request) {

    $message = "File name is not set or its invalid";
    $code    = 404;

    $data = request()->json()->all();

    if(isset($data['filename']))
    {
        Storage::put($data['filename']);

        $dependencies_array = array();
        $ran_command        = array();

        for($i = 0;$i < count($data['tasks']);$i++)
        {
            if(!isset($data['tasks'][$i]['dependencies']))
            {
                Storage::prepend($data['filename'], $data['tasks'][$i]['command']);

            }else
            {
                if(is_array($data['tasks'][$i]['dependencies']))
                {
                    $dependency = $data['tasks'][$i]['dependencies'];

                    for($z = 0; $z < count($dependency);$z++)
                    {
                        $dependencies_array[] = array('dependency' => $dependency[$z], 'command' => $data['tasks'][$i]['command']);

                    }
                }
            }
        }

        $dependency  = array_column($dependencies_array, 'dependency');
        $command     = array_column($dependencies_array, 'command');


        array_multisort($dependency, SORT_DESC, $command, SORT_ASC, $dependencies_array);


        for ($i = 0;$i < count($dependencies_array);$i++)
        {
            if(!in_array($dependencies_array[$i]['command'],$ran_command))
            {
                Storage::append($data['filename'], $dependencies_array[$i]['command']);
            }

            $ran_command[] = $dependencies_array[$i]['command'];

        }

        $message = "Saved tasks to file";
        $code    = 201;
    }



    return response()->json([
        "message" => $message
    ], $code);





});
