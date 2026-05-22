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
use App\Models\Gallery;
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
        $company = CompanyDetails::select('company_name', 'fav_icon', 'google_site_verification', 'footer_content', 'facebook', 'twitter', 'linkedin', 'website', 'phone1', 'email1', 'address1','address2','company_logo','copyright','google_map', 'about_us_bn', 'about_us_en')->first();
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

        $galleryPreview = Gallery::active()->ordered()->take(4)->get();
        $galleryTotal = Gallery::active()->count();

        return view('frontend.index', compact('categories','company','hero','packages','services','whyChooseItems','hospitals','partners','blogs','teams', 'galleryPreview', 'galleryTotal'));
    }

    public function packages()
    {
        $company = CompanyDetails::select('company_name', 'fav_icon', 'google_site_verification', 'footer_content', 'facebook', 'twitter', 'linkedin', 'website', 'phone1', 'email1', 'address1','address2','company_logo','copyright','google_map')->first();
        
        // ✅ Get only active packages
        $packages = MedicalPackage::with('translations')
            ->get()
            ->groupBy('category');

        // ✅ Get ordered categories (Surgery -> Treatment -> Checkup -> Alphabetical -> Other Services)
        $orderedCategories = MedicalPackage::getOrderedCategories();
        
        // ✅ Filter to only show categories that have packages
        $activeCategories = [];
        foreach ($orderedCategories as $key => $label) {
            if ($packages->has($key)) {
                $activeCategories[$key] = $label;
            }
        }

        // ✅ Get dynamic banner
        $banner = BannerSection::where('page', 'Packages')->where('status', 1)->first();

        return view('frontend.packages', compact('company', 'packages', 'activeCategories', 'banner'));
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

        $num1 = rand(1, 10);
        $num2 = rand(1, 10);
        session(['captcha_result' => $num1 + $num2]);

        return view('frontend.contact', compact('company','services','banner','num1', 'num2'));
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
        
        // ✅ Fallback to English if current locale translation doesn't exist
        if (!$translation) {
            $translation = $package->translate('en');
        }

        // ✅ Get features from the TRANSLATION model
        $features = $translation->features ?? [];
        
        // ✅ Filter out empty values just in case
        $features = array_filter($features, function($f) {
            return !empty($f) && trim($f) !== '';
        });

        return view('frontend.package_details', compact('package', 'translation', 'features'));
    }

    public function contactStore(Request $request)
    {
        // 1. Honeypot check
        if (!empty($request->website_url)) {
            return back()->with('success', 'Inquiry submitted successfully!');
        }

        // 2. Time-based check
        if ($request->filled('form_loaded_at')) {
            $diff = time() - (int) $request->form_loaded_at;
            if ($diff < 5) {
                return back()->with('error', 'Submission too fast. Please try again.')->withInput();
            }
        }

        // 3. Math CAPTCHA check
        $request->validate([
            'captcha_answer' => 'required|numeric',
        ]);

        if ($request->captcha_answer != session('captcha_result')) {
            return back()->withErrors(['captcha_answer' => 'The math answer is incorrect.'])->withInput();
        }
        session()->forget('captcha_result');

        // 4. Standard Validation
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email'     => 'required|email|max:255',
            'phone'     => 'nullable|string|max:50',
            'country'   => 'nullable|string|max:100',
            'message'   => 'nullable|string|max:5000',
            'file'      => 'nullable|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240'
        ]);

        // ===== ANTI-SPAM CHECK 4: Spam keyword filter =====
        $spamKeywords = [
            'рассылк', 'обратитесь', 'seo', 'viagra', 'casino', 'lottery',
            'crypto', 'bitcoin', 'бесплатно', 'заработок', 'продвижени',
            'контактные формы', 'аудитори', 'хороший вариант', 'дешево',
            'telegram', '@', 'http://', 'https://', 'www.',
            'porn', 'dating', 'click here', 'free money', 'качественн'
        ];

        $checkFields = [
            $request->full_name, 
            $request->message, 
            $request->country
        ];

        foreach ($checkFields as $field) {
            if ($field) {
                $fieldLower = mb_strtolower($field);
                foreach ($spamKeywords as $keyword) {
                    if (str_contains($fieldLower, mb_strtolower($keyword))) {
                        // Log the spam attempt
                        \Log::warning('Spam blocked (keyword filter)', [
                            'keyword' => $keyword,
                            'field' => $field,
                            'ip' => $request->ip(),
                            'data' => $request->except(['file', 'g-recaptcha-response', 'website_url', 'form_loaded_at'])
                        ]);
                        // Pretend success so spammer doesn't know
                        return back()->with('success', 'Inquiry submitted successfully!');
                    }
                }
            }
        }

        // ===== ANTI-SPAM CHECK 5: Check for URLs in message =====
        if ($request->message) {
            $urlPattern = '/(http|https|ftp|www\.)/i';
            if (preg_match($urlPattern, $request->message)) {
                \Log::warning('Spam blocked (URL in message)', [
                    'ip' => $request->ip(),
                    'message' => $request->message
                ]);
                return back()->with('success', 'Inquiry submitted successfully!');
            }
        }

        // ===== File Upload =====
        $filePath = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $fileName = time().'_'.Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                        .'.'.$file->getClientOriginalExtension();

            $destinationPath = public_path('uploads/contact');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $fileName);

            $filePath = 'uploads/contact/'.$fileName;
        }

        // ===== Store Contact =====
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

    public function gallery(Request $request)
    {
        $company = CompanyDetails::select('company_name', 'fav_icon', 'google_site_verification', 'footer_content', 'facebook', 'twitter', 'linkedin', 'website', 'phone1', 'email1', 'address1','address2','company_logo','copyright','google_map')->first();
        $data = MedicalPackage::with('translations')->get();
        $banner = BannerSection::where('page', 'Gallery')->first() ?? new BannerSection();

        $query = Gallery::active()->ordered();

        // ✅ Added 'youtube' to allowed filters
        if ($request->filled('type') && in_array($request->type, ['image', 'video', 'youtube'])) {
            $query->where('type', $request->type);
        }

        $items = $query->get();

        return view('frontend.gallery', compact('company','data','banner','items'));
    }

    
    public function aboutUs()
    {
        $companyDetails = CompanyDetails::first();
        return view('frontend.about', compact('companyDetails'));
    }

}
