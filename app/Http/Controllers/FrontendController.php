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
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use App\Models\HeroSection;
use App\Models\MedicalPackage;
use App\Models\MedicalService;
use App\Models\WhyChoose;
    use Illuminate\Support\Str;

class FrontendController extends Controller
{
    public function index()
    {
        $categories = Category::with('products')->where('status', 1)->get();
        $company = CompanyDetails::select('company_name', 'fav_icon', 'google_site_verification', 'footer_content', 'facebook', 'twitter', 'linkedin', 'website', 'phone1', 'email1', 'address1','address2','company_logo','copyright','google_map')->first();
        $hero = HeroSection::with('translations')->latest()->first();
        $packages = MedicalPackage::with('translations')->take(3)->get();
        $services = MedicalService::with('translations')->where('status',1)->orderBy('order')->get();

        $whyChooseItems = WhyChoose::with('translations')->where('status', 1)->orderBy('serial')->get();

        return view('frontend.index', compact('categories','company','hero','packages','services','whyChooseItems'));
    }

    public function packages()
    {
        $company = CompanyDetails::select('company_name', 'fav_icon', 'google_site_verification', 'footer_content', 'facebook', 'twitter', 'linkedin', 'website', 'phone1', 'email1', 'address1','address2','company_logo','copyright','google_map')->first();
        $packages = MedicalPackage::with('translations')->get();
        return view('frontend.packages', compact('company','packages'));
    }

    
    public function services()
    {
        $company = CompanyDetails::select('company_name', 'fav_icon', 'google_site_verification', 'footer_content', 'facebook', 'twitter', 'linkedin', 'website', 'phone1', 'email1', 'address1','address2','company_logo','copyright','google_map')->first();
        $services = MedicalService::with('translations')->where('status',1)->orderBy('order')->get();
        return view('frontend.services', compact('company','services'));
    }

    public function contact()
    {
        $company = CompanyDetails::select('company_name', 'fav_icon', 'google_site_verification', 'footer_content', 'facebook', 'twitter', 'linkedin', 'website', 'phone1', 'email1', 'address1','address2','company_logo','copyright','google_map')->first();
        $services = MedicalService::with('translations')->where('status',1)->orderBy('order')->get();
        return view('frontend.contact', compact('company','services'));
    }



    public function contactStore(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email'     => 'required|email|max:255',
            'phone'     => 'nullable|string|max:50',
            'country'   => 'nullable|string|max:100',
            'message'   => 'nullable|string',
            'file'      => 'nullable|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240'
        ]);

        $filePath = null;

        if ($request->hasFile('file')) {

            $file = $request->file('file');

            $fileName = time().'_'.Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                        .'.'.$file->getClientOriginalExtension();

            $destinationPath = public_path('uploads/contact');

            // Create folder if not exists
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $fileName);

            $filePath = 'uploads/contact/'.$fileName;
        }

        Contact::create([
            'full_name' => $request->full_name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'country'   => $request->country,
            'message'   => $request->message,
            'file'      => $filePath,
            'status'    => 0
        ]);

        return back()->with('success', 'Inquiry submitted successfully!');
    }


}
