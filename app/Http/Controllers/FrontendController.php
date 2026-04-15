<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\ContactEmail;
use App\Mail\ContactMail;
use App\Models\Award;
use App\Models\BannerSection;
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
use App\Models\Hospital;
use App\Models\MedicalPackage;
use App\Models\MedicalService;
use App\Models\Partner;
use App\Models\Team;
use App\Models\WhyChoose;
    use Illuminate\Support\Str;

class FrontendController extends Controller
{
    public function index()
    {
        $categories = Category::with('products')->where('status', 1)->get();
        $company = CompanyDetails::select('company_name', 'fav_icon', 'google_site_verification', 'footer_content', 'facebook', 'twitter', 'linkedin', 'website', 'phone1', 'email1', 'address1','address2','company_logo','copyright','google_map')->first();
        $hero = HeroSection::with('translations')->latest()->first();
        $packages = MedicalPackage::with('translations')->get();
        $services = MedicalService::with('translations')->where('status',1)->orderBy('order')->get();

        $whyChooseItems = WhyChoose::with('translations')->where('status', 1)->orderBy('serial')->get();

        $hospitals = Hospital::latest()->take(8)->get();
        $partners = Partner::orderBy('sort_order', 'asc')->get();

        
        $teams = Team::orderBy('order', 'asc')->get();


        $blogs = Blog::query()
                ->with(['translations' => function ($query) {
                    $query->select('id', 'blog_id', 'locale', 'title', 'summary');
                }])
                ->where('status', 1)
                ->latest()
                ->get(['id', 'image', 'slug', 'read_time', 'created_at']); 


        return view('frontend.index', compact('categories','company','hero','packages','services','whyChooseItems','hospitals','partners','blogs','teams'));
    }

    public function packages()
    {
        $company = CompanyDetails::select('company_name', 'fav_icon', 'google_site_verification', 'footer_content', 'facebook', 'twitter', 'linkedin', 'website', 'phone1', 'email1', 'address1','address2','company_logo','copyright','google_map')->first();
        $packages = MedicalPackage::with('translations')->get();
        $banner = BannerSection::where('page', 'Packages')->first() ?? new BannerSection();
        return view('frontend.packages', compact('company','packages','banner'));
    }

    public function blogList()
    {
        $company = CompanyDetails::select('company_name', 'fav_icon', 'google_site_verification', 'footer_content', 'facebook', 'twitter', 'linkedin', 'website', 'phone1', 'email1', 'address1','address2','company_logo','copyright','google_map')->first();
        
        $blogs = Blog::query()
                ->with(['translations' => function ($query) {
                    // Only select columns needed for the card view
                    $query->select('id', 'blog_id', 'locale', 'title', 'summary');
                }])
                ->where('status', 1)
                ->latest()
                ->get(['id', 'image', 'slug', 'read_time', 'created_at']); 

        return view('frontend.blog-list', compact('company','blogs'));
    }

    
    public function services()
    {
        $company = CompanyDetails::select('company_name', 'fav_icon', 'google_site_verification', 'footer_content', 'facebook', 'twitter', 'linkedin', 'website', 'phone1', 'email1', 'address1','address2','company_logo','copyright','google_map')->first();
        $services = MedicalService::with('translations')->where('status',1)->orderBy('order')->get();
        $banner = BannerSection::where('page', 'Services')->first() ?? new BannerSection();
        return view('frontend.services', compact('company','services','banner'));
    }

    public function contact()
    {
        $company = CompanyDetails::select('company_name', 'fav_icon', 'google_site_verification', 'footer_content', 'facebook', 'twitter', 'linkedin', 'website', 'phone1', 'email1', 'address1','address2','company_logo','copyright','google_map')->first();
        $services = MedicalService::with('translations')->where('status',1)->orderBy('order')->get();
        $banner = BannerSection::where('page', 'Contact')->first() ?? new BannerSection();
        return view('frontend.contact', compact('company','services','banner'));
    }


    public function blogDetails($slug)
    {
        // Fetch specific blog by slug
        $blog = Blog::with('translations')->where('slug', $slug)->firstOrFail();
        
        // Fetch trending blogs (last 2-3 blogs excluding current one)
        $trending = Blog::with('translations')
                    ->where('id', '!=', $blog->id)
                    ->latest()
                    ->take(3)
                    ->get();

        return view('frontend.blog_details', compact('blog', 'trending'));
    }

    public function packagesDetails($id)
    {
        // Fetch the package with translations
        $package = MedicalPackage::with('translations')->findOrFail($id);
        
        // Get translation for current locale
        $translation = $package->translate(app()->getLocale());
        
        // Decode features (handled by $casts in your model, but we ensure it's an array)
        $features = $package->features ?? [];

        return view('frontend.package_details', compact('package', 'translation', 'features'));
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
