<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AboutUs;
use App\Models\ContactDetails;
use App\Models\AddEmployee;
use Illuminate\Support\Facades\Log;
use App\Repositories\ResponseRepository;

class ImageController extends Controller
{
    public function __construct(ResponseRepository $response) {
        $this->response = $response;
    }

    public function imageUpload(Request $request) {
        if($request->hasFile('image')) {
            switch( $request->menu ) {

                case 'emp_image':
                    $uploadUrl = $this->response->cloudinaryImage($request->file('image'), 'employeimage','emp_image');
                    AddEmployee::first()->update(['emp_image' => $uploadUrl]);
                    return $this->response->jsonResponse(false, 'Image Uploaded Successfully', $request->menu, 201);
                    break;

                case 'header_four_image':
                    $uploadUrl = $this->response->cloudinaryImage($request->file('image'), 'HomePage','header_four_image');
                    AboutUs::first()->update(['header_four_image' => $uploadUrl]);
                    return $this->response->jsonResponse(false, 'Home Image Uploaded Successfully', $request->menu, 201);
                    break;

                case 'aboutusbanner':
                    $uploadUrl = $this->response->cloudinaryImage($request->file('image'), 'aboutusbanner','aboutusbanner');
                    AboutUs::first()->update(['about_us_banner' => $uploadUrl]);
                    return $this->response->jsonResponse(false, 'About Us Banner Image Uploaded Successfully', $request->menu, 201);
                    break;

                case 'imagetwo':
                    $uploadUrl = $this->response->cloudinaryImage($request->file('image'), 'Aboutus','imagetwo');
                    AboutUs::first()->update(['header_image_two' => $uploadUrl]);
                    return $this->response->jsonResponse(false, 'About us Image Uploaded Successfully', $request->menu, 201);
                    break;

                case 'tarvelone':
                    $uploadUrl = $this->response->cloudinaryImage($request->file('image'), 'Tarvel','tarvelone');
                    AboutUs::first()->update(['travel_image_one' => $uploadUrl]);
                    return $this->response->jsonResponse(false, 'About us Image Uploaded Successfully', $request->menu, 201);
                    break;

                case 'tarveltwo':
                    $uploadUrl = $this->response->cloudinaryImage($request->file('image'), 'Tarvel','tarveltwo');
                    AboutUs::first()->update(['travel_image_two' => $uploadUrl]);
                    return $this->response->jsonResponse(false, 'About us Image Uploaded Successfully', $request->menu, 201);
                    break;

                case 'tarvethree':
                    $uploadUrl = $this->response->cloudinaryImage($request->file('image'), 'Tarvel','tarvethree');
                    AboutUs::first()->update(['travel_image_three' => $uploadUrl]);
                    return $this->response->jsonResponse(false, 'About us Image Uploaded Successfully', $request->menu, 201);
                    break;

                    case 'contact_banner_image':
                        $uploadUrl = $this->response->cloudinaryImage($request->file('image'), 'Contact','contact_banner_image');
                        ContactDetails::first()->update(['contact_banner_image' => $uploadUrl]);
                        return $this->response->jsonResponse(false, 'Contact Image Uploaded Successfully', $request->menu, 201);
                        break;

            }

        } else {
            return $this->response->jsonResponse(true, 'Image Size is too high', [], 202);
        }
    }
}
