<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Blog;
use App\Models\BlogTranslation;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Blog::with('translations')->latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('title', function($row) {
                    return $row->translation('en')->title ?? 'No Title';
                })
                ->addColumn('action', function($row) {
                    return '<button id="EditBtn" rid="'.$row->id.'" class="btn btn-sm btn-primary">Edit</button>
                            <button class="btn btn-sm btn-danger deleteBtn" data-delete-url="'.route('blogs.destroy', $row->id).'" data-table="#blogTable">Delete</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.blogs.index');
    }

    public function store(Request $request)
    {
        // 1. Create the main Blog record
        $blog = new Blog();
        // We use the English title to generate the slug
        $blog->slug = Str::slug($request->en['title']); 
        $blog->read_time = $request->read_time;
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/blogs'), $filename);
            $blog->image = 'uploads/blogs/' . $filename;
        }
        $blog->save();

        // 2. Save Translations using the array structure from your Blade
        foreach (config('translatable.locales') as $locale) {
            // Accessing data like $request->en['title'] or $request->bn['title']
            $translationData = $request->input($locale); 

            BlogTranslation::create([
                'blog_id'     => $blog->id,
                'locale'      => $locale,
                'title'       => $translationData['title'],
                'summary'     => $translationData['summary'],
                'description' => $translationData['description'],
                'tags'        => $translationData['tags'],
            ]);
        }

        return response()->json(['message' => 'Blog posted successfully!']);
    }

    public function update(Request $request)
    {
        $blog = Blog::findOrFail($request->codeid);
        $blog->read_time = $request->read_time;
        
        // Update slug only if English title changed (optional)
        $blog->slug = Str::slug($request->en['title']);

        if ($request->hasFile('image')) {
            // Delete old image
            if (File::exists(public_path($blog->image))) {
                File::delete(public_path($blog->image));
            }
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/blogs'), $filename);
            $blog->image = 'uploads/blogs/' . $filename;
        }
        $blog->save();

        // Update or Create translations
        foreach (config('translatable.locales') as $locale) {
            $translationData = $request->input($locale);

            BlogTranslation::updateOrCreate(
                ['blog_id' => $blog->id, 'locale' => $locale],
                [
                    'title'       => $translationData['title'],
                    'summary'     => $translationData['summary'],
                    'description' => $translationData['description'],
                    'tags'        => $translationData['tags'],
                ]
            );
        }

        return response()->json(['message' => 'Blog updated successfully!']);
    }


    public function edit($id)
    {
        return Blog::with('translations')->findOrFail($id);
    }

    



}