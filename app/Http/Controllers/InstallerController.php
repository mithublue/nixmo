<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Bouncer;

class InstallerController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('install.index');
    }

    /**
     * Process install the app.
     *
     * @return \Illuminate\Http\Response
     */
    public function process_install( Request $request )
    {
        $validatedData = $request->validate([
            'db_name' => 'required',
            'db_user' => 'required',
            'site_name' => 'required',
            'site_username' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        $values = [
            'DB_DATABASE' => $request->db_name,
            'DB_USERNAME' => $request->db_user,
            'DB_PASSWORD' => $request->db_password,
            'site_name' => $request->site_name
        ];

        //env variable setup
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        if (count($values) > 0) {
            foreach ($values as $envKey => $envValue) {

                $str .= "\n"; // In case the searched variable is in the last line without \n
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
        if ( file_put_contents($envFile, $str)) {
            $exitCode = \Illuminate\Support\Facades\Artisan::call('migrate');

            //create roles and permissions
            $admin = Bouncer::role()->firstOrCreate([
                'name' => 'admin',
                'title' => 'Administrator',
            ]);
            Bouncer::allow('admin')->everything();

            option(['__site_name' => $request->site_name]);
            $user = new \App\User();
            $user->username = $request->site_username;
            $user->password = bcrypt($request->password);
            $user->email = $request->email;
            $user->save();

            Bouncer::assign('admin')->to($user);
            return redirect()->route('install_success');
        };

        return redirect()->route('install_fail');
    }

    /**
     * Show success message on success
     */
    public function install_success()
    {
        return view('install.success');
    }

    /**
     * Display the Error message
     * on installation failure.
     *
     */
    public function install_fail()
    {
        return view('install.fail');
    }
}
