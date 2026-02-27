<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\ContactEmail;
use App\Mail\ContactMail;
use App\Models\Award;
use App\Models\Blog;
use App\Models\Category;
use App\Models\CompanyDetails;
use App\Models\Master;
use App\Models\Research;
use App\Models\Slider;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $slider = Slider::orderby('id')->first();
        $categories = Category::with('products')->where('status', 1)->get();
        $company = CompanyDetails::select('company_name', 'fav_icon', 'google_site_verification', 'footer_content', 'facebook', 'twitter', 'linkedin', 'website', 'phone1', 'email1', 'address1','address2','company_logo','copyright','google_map')->first();

        return view('frontend.index', compact('slider','categories','company'));
    }

}
