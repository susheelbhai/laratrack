<?php

namespace Susheelbhai\Laratrack\Repository;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Susheelbhai\Laratrack\Mail\NotifyLicence;
use Susheelbhai\Laratrack\Models\Visitor;

class LicenceRepository
{
    function trackLicence()
    {
        $visitors = Visitor::whereIp(Request::ip())->first();
        // dd($visitors);
        $allowed_url = [
            'http://127.0.0.1:8000',
            'http://localhost/frontiera/public_html',
            'https://preview.digilight.in/frontier/public_html',
            'https://www.frontierb2b.in',
            'https://frontierb2b.in',
            'http://www.frontierb2b.in',
            'http://frontierb2b.in'
        ];
        $visited_url = Request::root();
        if (Str::contains($visited_url, ['127.0.0.1', 'localhost'])) {
            return true;
        }
        if (in_array($visited_url, $allowed_url)) {
            return true;
        } elseif($visitors == null) {
            Visitor::updateOrCreate(['ip'=> Request::ip()]);
            return false;
        }
        else{
            return true;
        }
    }
    function notifyLicence()
    {

        $to = "susheelkrsingh306@gmail.com";
        $subject = "HTML email";

        $message = "
                    <html>
                    <head>
                    <title>HTML email</title>
                    </head>
                    <body>
                    <p> Your website copy is now live on <a href=".Request::root().">".Request::root()."</a> </p>
                    <table>
                    <tr>
                    <th> URL </th>
                    <td>" . Request::url() ." </td>
                    </tr>
                    <tr>
                    <th> Root URL </th>
                    <th>" . Request::url() ." </th>
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
        // More headers
        $headers .= 'From: <susheelkrsingh306@gmail.com>' . "\r\n";

        try {
            Mail::to($to)->send(new NotifyLicence());
            mail($to, $subject, $message, $headers);
        } catch (\Throwable $th) {
            // throw $th;
        }
    }
}
