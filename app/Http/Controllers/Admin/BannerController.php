<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BannerSection;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class BannerController extends Controller
{
    protected $pageOptions = [
        'About'      => 'About',
        'Blog'       => 'Blog',
        'Packages'      => 'Packages',
        'Hospital' => 'Hospital',
        'Services'    => 'Services',
        'Contact'    => 'Contact',
        'Gallery'    => 'Gallery',
    ];

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $banners = BannerSection::orderBy('id', 'desc');
            
            return DataTables::of($banners)
                ->addIndexColumn()
                ->addColumn('page', function ($row) {
                    $colors = [
                        'About'      => 'primary',
                        'Blog'       => 'info',
                        'Packages'      => 'warning',
                        'Hospital' => 'success',
                        'Services'    => 'secondary',
                        'Contact'    => 'danger',
                        'Gallery'    => 'dark',
                    ];
                    $color = $colors[$row->page] ?? 'secondary';
                    return '<span class="badge bg-' . $color . '">' . $row->page . '</span>';
                })
                ->addColumn('short_title', function ($row) {
                    return $row->short_title ? Str::limit($row->short_title, 30) : '<span class="text-muted">N/A</span>';
                })
                ->addColumn('image', function ($row) {
                    if ($row->image) {
                        return '<img src="' . asset($row->image) . '" width="60" height="35" 
                                style="object-fit:cover; border-radius:4px; border:1px solid #dee2e6;">';
                    }
                    return '<span class="text-muted">No Image</span>';
                })
                ->addColumn('status', function ($row) {
                    if ($row->status) {
                        return '<span class="badge bg-success"><i class="ri-check-line me-1"></i>Active</span>';
                    }
                    return '<span class="badge bg-danger"><i class="ri-close-line me-1"></i>Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <button class="btn btn-sm btn-info EditBtn" data-id="' . $row->id . '">
                            <i class="ri-pencil-fill"></i>
                        </button>
                        <button class="btn btn-sm btn-danger deleteBtn" 
                                data-delete-url="' . route('banner-section.delete', $row->id) . '" 
                                data-method="DELETE" 
                                data-table="#bannerTable">
                            <i class="ri-delete-bin-fill"></i>
                        </button>
                        ';
                })
                ->rawColumns(['page', 'short_title', 'image', 'status', 'action'])
                ->make(true);
        }

        return view('admin.banner-sections.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'page'            => 'required|string|unique:banner_sections,page',
            'name'            => 'nullable|string|max:255',
            'short_title'     => 'nullable|string|max:255',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'meta_image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'          => 'nullable|boolean',
        ]);

        $data = $request->except(['image', 'meta_image']);
        $data['created_by'] = auth()->id();

        // Banner image -> resize to standard 1920x600
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request->file('image'), 'banner', 1920, 600);
        }

        // Meta image -> resize to standard OG size 1200x630
        if ($request->hasFile('meta_image')) {
            $data['meta_image'] = $this->uploadFile($request->file('meta_image'), 'banner/meta', 1200, 630);
        }

        BannerSection::create($data);

        return response()->json(['message' => 'Banner section added successfully.']);
    }

    public function update(Request $request)
    {
        $request->validate([
            'page'            => 'required|string|unique:banner_sections,page,' . $request->id,
            'name'            => 'nullable|string|max:255',
            'short_title'     => 'nullable|string|max:255',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'meta_image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'          => 'nullable|boolean',
        ]);

        $banner = BannerSection::findOrFail($request->id);
        $data = $request->except(['image', 'meta_image']);
        $data['updated_by'] = auth()->id();

        // Banner image -> resize to standard 1920x600
        if ($request->hasFile('image')) {
            if ($banner->image && File::exists(public_path($banner->image))) {
                File::delete(public_path($banner->image));
            }
            $data['image'] = $this->uploadFile($request->file('image'), 'banner', 1920, 600);
        }

        // Meta image -> resize to standard OG size 1200x630
        if ($request->hasFile('meta_image')) {
            if ($banner->meta_image && File::exists(public_path($banner->meta_image))) {
                File::delete(public_path($banner->meta_image));
            }
            $data['meta_image'] = $this->uploadFile($request->file('meta_image'), 'banner/meta', 1200, 630);
        }

        $banner->update($data);

        return response()->json(['message' => 'Banner section updated successfully.']);
    }

    /**
     * Upload and resize file to exact dimensions (crop to fit)
     */
    private function uploadFile($file, $path, $width = null, $height = null)
    {
        $uploadPath = public_path('uploads/' . $path);
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        $filename = time() . '_' . $file->getClientOriginalName();
        $filepath = $uploadPath . '/' . $filename;

        // If width & height provided, resize with crop (fit)
        if ($width && $height) {
            Image::make($file->getRealPath())
                ->fit($width, $height)
                ->save($filepath, 80);
        } else {
            $file->move($uploadPath, $filename);
        }

        return 'uploads/' . $path . '/' . $filename;
    }

    public function edit($id)
    {
        return response()->json(BannerSection::find($id));
    }



    public function destroy($id)
    {
        $banner = BannerSection::find($id);

        if ($banner) {
            // Delete banner image
            if ($banner->image && File::exists(public_path($banner->image))) {
                File::delete(public_path($banner->image));
            }
            // Delete meta image
            if ($banner->meta_image && File::exists(public_path($banner->meta_image))) {
                File::delete(public_path($banner->meta_image));
            }
            $banner->delete();
        }

        return response()->json(['message' => 'Deleted successfully.']);
    }

    
    
}