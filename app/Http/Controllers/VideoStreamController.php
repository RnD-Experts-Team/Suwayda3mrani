<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class VideoStreamController extends Controller
{
    public function stream(Request $request, $filename)
    {
        // Validate the file exists
        if (!Storage::exists("public/videos/{$filename}")) {
            abort(404, 'Video not found');
        }

        $path = Storage::path("public/videos/{$filename}");
        $size = filesize($path);
        $length = $size;
        $start = 0;
        $end = $size - 1;

        // Handle range requests for video streaming
        if ($request->hasHeader('Range')) {
            $range = $request->header('Range');
            list(, $range) = explode('=', $range, 2);
            
            if (strpos($range, ',') !== false) {
                return response('Requested Range Not Satisfiable', 416)
                    ->header('Content-Range', "bytes $start-$end/$size");
            }

            if ($range == '-') {
                $c_start = $size - substr($range, 1);
            } else {
                $range = explode('-', $range);
                $c_start = $range[0];
                $c_end = (isset($range[1]) && is_numeric($range[1])) ? $range[1] : $size;
            }

            $c_end = ($c_end > $end) ? $end : $c_end;
            if ($c_start > $c_end || $c_start > $size - 1 || $c_end >= $size) {
                return response('Requested Range Not Satisfiable', 416)
                    ->header('Content-Range', "bytes $start-$end/$size");
            }

            $start = $c_start;
            $end = $c_end;
            $length = $end - $start + 1;
        }

        $response = new Response();
        $response->header('Content-Type', 'video/mp4');
        $response->header('Accept-Ranges', 'bytes');
        $response->header('Content-Length', $length);
        $response->header('Content-Range', "bytes {$start}-{$end}/{$size}");
        
        if ($request->hasHeader('Range')) {
            $response->setStatusCode(206);
        }

        $response->setCallback(function() use ($path, $start, $length) {
            $file = fopen($path, 'r');
            fseek($file, $start);
            $buffer = 1024 * 8;
            
            while (!feof($file) && ($p = ftell($file)) <= $end) {
                if ($p + $buffer > $end) {
                    $buffer = $end - $p + 1;
                }
                echo fread($file, $buffer);
                flush();
            }
            
            fclose($file);
        });

        return $response;
    }
}
