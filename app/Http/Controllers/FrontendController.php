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


    public function storeContact(Request $request)
    {
        try {
            // 1. Validation matching translated form fields
            $request->validate([
                'full_name'   => 'required|string|min:2|max:100',
                'email'       => 'required|email|max:100',
                'phone'       => 'nullable|string|max:20',
                'subject'     => 'nullable|string',
                'category_id' => 'nullable|exists:categories,id',
                'message'     => 'required|string|min:10|max:3000',
            ], [
                'full_name.required' => __('Full Name is required'),
                'full_name.min'      => __('Full Name must be at least :min characters'),
                'email.required'     => __('Email Address is required'),
                'email.email'        => __('Enter a valid Email Address'),
                'message.required'   => __('Your Message is required'),
                'message.min'        => __('Your Message must be at least :min characters'),
            ]);

            // 2. Save contact
            $contact = new Contact();
            $names = explode(' ', $request->input('full_name'), 2);
            $contact->first_name = $names[0];
            $contact->last_name  = $names[1] ?? '';

            $contact->full_name   = $request->input('full_name');
            $contact->email       = $request->input('email');
            $contact->phone       = $request->input('phone');
            $contact->subject     = $request->input('subject');
            $contact->category_id = $request->input('category_id');
            $contact->message     = $request->input('message');

            $contact->save();

            // 3. Email Notification
            $contactEmails = ContactMail::where('status', 1)->pluck('email');
            foreach ($contactEmails as $email) {
                Mail::to($email)->send(new ContactMail($contact));
            }

            return redirect()->back()->with('success', __('Your message has been sent successfully!'));

        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        }
    }

}
