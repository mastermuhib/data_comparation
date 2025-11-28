<?php

namespace App\Classes;

use Illuminate\Support\Facades\File;
use App\Classes\S3;

class upload
{
    public function img($file)
    {
        $s3        = new S3(env('3fe44de7af6171ce0fca'), env('gaL9XLtRZRHH1Q3TvDbledkOU9hld+fHcdP01lSg'));
        //dd($s3);
        $file_name = $file->hashName();
        $file_path = base_path('public/images/' . $file_name);
        $file->move(base_path('public/images/'), $file_name);
        $s3->putObjectFile($file_path, 'kandidat', $file_name, S3::ACL_PUBLIC_READ);
        File::delete($file_path);
        return env('S3_PATH') . $file_name;
    }
    public function img2($file)
    {
        $s3        = new S3('3fe44de7af6171ce0fca', 'gaL9XLtRZRHH1Q3TvDbledkOU9hld+fHcdP01lSg');
        $file_name = $file->hashName();
        $file_path = base_path('public/images/' . $file_name);
        $file->move(base_path('public/images/'), $file_name);
        $s3->putObjectFile($file_path,'kandidat', $file_name, S3::ACL_PUBLIC_READ);
        File::delete($file_path);
        return $file_name;
    }

    public function imgNotDelete($file) {
        $s3        = new S3('3fe44de7af6171ce0fca', 'gaL9XLtRZRHH1Q3TvDbledkOU9hld+fHcdP01lSg');
        $file_name = $file->hashName();
        $file_path = base_path('public/assets/file_hasil/' . $file_name);
        $file->move(base_path('public/assets/file_hasil/'), $file_name);
        $s3->putObjectFile($file_path,'kandidat', $file_name, S3::ACL_PUBLIC_READ);
        //File::delete($file_path);
        return $file_name;
    }

    public function img_fixed($file)
    {
        $s3        = new S3(env('AWS_ACCESS_KEY_ID'), env('AWS_SECRET_ACCESS_KEY'));
        $file_name = $file->hashName();
        $file_path = base_path('public/images/' . $file_name);
        $file->move(base_path('public/images/'), $file_name);
        $s3->putObjectFile($file_path, env('AWS_BUCKET'), $file_name, S3::ACL_PUBLIC_READ);
        File::delete($file_path);
        return env('S3_PATH') . $file_name;
    }
}
