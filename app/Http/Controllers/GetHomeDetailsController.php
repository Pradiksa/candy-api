<?php

namespace App\Http\Controllers;
use App\Repositories\ResponseRepository;
use Illuminate\Support\Facades\Log;
use App\Models\ContactUs;
use App\Models\AboutUs;
use App\Models\Testimony;
use App\Models\FooterBlock;
use DB;
use Carbon\Carbon;
use Mail;
use App\Models\HomeBanner;
use App\Models\Featured;
use App\Models\Package;
use App\Models\PackageType;
use App\Models\WhoWeAreBanner;
use App\Models\Category;
use App\Models\MainMenu;
use App\Models\SubCategory;
use App\Models\SubCategoriesImage;
use App\Models\Products;
use App\Models\ContactDetails;
use App\Models\ProductsImage;

class GetHomeDetailsController extends Controller
{
    public function __construct(ResponseRepository $response) {
        $this->response = $response;
    }


    public function getcontactDetails() {
        $data['consultUs'] = ConsultUs::where('active_status', 1)->orderBy('id', 'desc')->get();
        $data['medialink'] = AboutUs::all();
        return $this->response->jsonResponse(false,"Contact Us Page Details Fetched Successfully", $data, 200);
    }
}
