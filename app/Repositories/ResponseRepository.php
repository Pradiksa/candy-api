<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Cloudinary;

class ResponseRepository
{
    //Returning a json response for overall api in a project
    public function jsonResponse($error, $message, $data, $code)
    {
        return response()->json(array(
            'error' => $error,
            'message' => $message,
            'data' => $data,
            'code' => $code,
        ));
    }

    //setting a api messages here
    public function message($module, $type) {
        $msg = [
            $module => [
                'index' => 'Listed All '.$module,
                'store' => $module.' Created',
                'show' => $module.' Shown',
                'update' => $module.' Updated',
                'destroy' => $module.' Deleted',
                'getActive' => 'Listed Active '.$module,
                'search' => $module.' Filtered',
                'image' => $module.' Image Updated'
            ]
        ];
        return $msg[$module][$type].' SuccessFully';
    }

    public function cloudinaryImage($file, $folder, $name) {
        $image_path = $file->getRealPath();
        $uploadUrl = Cloudinary::upload($image_path, ['folder' => 'Candy/'.$folder, 'public_id' => $name])->getSecurePath();
        return $uploadUrl;
    }

    public function cloudinaryImageResume($file, $folder, $name) {
        $uploadUrl = Cloudinary::upload($file, ['folder' => 'Candy/'.$folder, 'public_id' => $name])->getSecurePath();
        return $uploadUrl;
    }

    public function validate($request, $rules) {
        $validator = Validator::make($request, $rules);
        if ($validator->fails()) {
            return $this->jsonResponse(true, 'Failed', $validator->errors(), 401);
        } else {
            return true;
        }
    }

    public function resizeMinBannerImage($type, $path, $name) {
        $url = public_path('images/min/'.$type.'/'.$name);
        $image = Image::make($path);
        $image->resize(100, 50);
        $image->save($url);
    }

    public function resizeMidBannerImage($type, $path, $name) {
        $url = public_path('images/mid/'.$type.'/'.$name);
        $image = Image::make($path);
        $image->resize(320, 120);
        $image->save($url);
    }

    public function resizeMinImage($type, $path, $name) {
        $url = public_path('images/min/'.$type.'/'.$name);
        $image = Image::make($path);
        $image->resize(300, 400);
        $image->save($url);
    }

    public function resizeMidImage($type, $path, $name) {
        $url = public_path('images/mid/'.$type.'/'.$name);
        $image = Image::make($path);
        $image->resize(510, 680);
        $image->save($url);
    }

    public function deleteImage($type, $name) {
        $path = public_path('images/'.$type.'/');
        @unlink($path.$name);
        @unlink($path.'min/'.$name);
        @unlink($path.'mid/'.$name);
    }

    public function generateSlug($value) {
        return Str::slug($value, '-');
    }

    public function currentDate() {
        return date("Y-m-d");
    }

    public function currentTime() {
        return date("g:i A");
    }

    public function getCloudUrl() {
        return 'https://storage.cloud.google.com/chrono_e_cart/';
    }

    function generateOrderID($l=10){
        $str = "";
        for ($x=0; $x<$l; $x++) $str .= substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 1);
        return $str;
    }
}
