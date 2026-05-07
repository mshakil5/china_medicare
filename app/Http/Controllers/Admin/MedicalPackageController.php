<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MedicalPackage;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class MedicalPackageController extends Controller
{
    public function index(Request $request)
    {
        // Check if this is a DataTable AJAX request (POST to /data endpoint)
        if ($request->is('admin/medical-package/data') || $request->has('draw')) {
            $data = MedicalPackage::with('translations')->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    $imgUrl = $row->image_url;
                    return '<img src="' . $imgUrl . '" alt="Package Image" 
                            class="img-thumbnail" style="width: 80px; height: 60px; object-fit: cover;"
                            onerror="this.src=\'' . asset('assets/images/no-image.png') . '\'">';
                })
                ->addColumn('title', function ($row) {
                    $translation = $row->translate('en');
                    $title = $translation->title ?? 'N/A';
                    $badge = '';
                    if ($row->is_popular) {
                        $badge .= '<span class="badge bg-info me-1">Popular</span>';
                    }
                    if ($row->is_featured) {
                        $badge .= '<span class="badge bg-warning">Featured</span>';
                    }
                    return $title . ' ' . $badge;
                })
                ->addColumn('category', function ($row) {
                    $categoryColors = [
                        'Surgery' => 'danger',
                        'Treatment' => 'primary',
                        'Checkup' => 'success',
                        'Dental' => 'info',
                        'Cosmetic' => 'warning',
                        'Cardiology' => 'dark',
                    ];
                    $color = $categoryColors[$row->category] ?? 'secondary';
                    return '<span class="badge bg-' . $color . '">' . $row->category . '</span>';
                })
                ->addColumn('price_range', function ($row) {
                    return $row->price_range ? '$' . $row->price_range : 'N/A';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.medical_package.edit', $row->id);
                    $deleteUrl = route('admin.medical_package.destroy', $row->id);
                    
                    return '<div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-info editBtn" 
                                        data-edit-url="' . $editUrl . '" 
                                        title="Edit">
                                    <i class="ri-edit-line"></i>
                                </button>
                                <button type="button" class="btn btn-danger deleteBtn" 
                                        data-delete-url="' . $deleteUrl . '" 
                                        data-table="#packageTable" 
                                        title="Delete">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>';
                })
                ->rawColumns(['image', 'title', 'category', 'action'])
                ->make(true);
        }

        // Normal page load
        $categories = MedicalPackage::getCategories();
        return view('admin.medical_packages.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = $this->validatePackage($request);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors'  => $validator->errors()
            ], 422);
        }

        $data = $this->preparePackageData($request);

        MedicalPackage::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Package created successfully!'
        ]);
    }

    public function edit($id)
    {
        $package = MedicalPackage::with('translations')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data'    => $package
        ]);
    }

    public function update(Request $request)
    {
        $validator = $this->validatePackage($request, true);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors'  => $validator->errors()
            ], 422);
        }

        $package = MedicalPackage::findOrFail($request->codeid);
        $data = $this->preparePackageData($request, $package);

        $package->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Package updated successfully!'
        ]);
    }

    public function destroy($id)
    {
        $package = MedicalPackage::findOrFail($id);
        
        if ($package->image && File::exists(public_path($package->image))) {
            File::delete(public_path($package->image));
        }
        
        if ($package->og_image && File::exists(public_path($package->og_image))) {
            File::delete(public_path($package->og_image));
        }

        $package->delete();

        return response()->json([
            'success' => true,
            'message' => 'Package deleted successfully!'
        ]);
    }

    private function validatePackage($request, $isUpdate = false)
    {
        $rules = [
            'category'     => 'required|string|max:255',
            'duration'     => 'nullable|string|max:255',
            'cities_count' => 'nullable|integer|min:1',
            'price_range'  => 'nullable|string|max:255',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'og_image'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'canonical_url'=> 'nullable|url|max:500',
            'features'     => 'nullable|array',
            'features.*'   => 'nullable|string|max:255',
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.title"] = 'required|string|max:255';
            $rules["$locale.subtitle"] = 'nullable|string|max:255';
            $rules["$locale.description"] = 'nullable|string|max:1000';
            $rules["$locale.meta_title"] = 'nullable|string|max:255';
            $rules["$locale.meta_description"] = 'nullable|string|max:500';
            $rules["$locale.meta_keywords"] = 'nullable|string|max:500';
        }

        return Validator::make($request->all(), $rules);
    }

    private function preparePackageData($request, $package = null)
    {
        $data = [
            'category'     => $request->category,
            'duration'     => $request->duration,
            'cities_count' => $request->cities_count ?? 1,
            'price_range'  => $request->price_range,
            'is_popular'   => $request->has('is_popular'),
            'is_featured'  => $request->has('is_featured'),
            'status'       => $request->has('status'),
            'features'     => array_filter($request->features ?? []),
            'canonical_url'=> $request->canonical_url,
        ];

        if ($request->hasFile('image')) {
            if ($package && $package->image && File::exists(public_path($package->image))) {
                File::delete(public_path($package->image));
            }
            $file = $request->file('image');
            $filename = time() . '_main_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/packages'), $filename);
            $data['image'] = 'uploads/packages/' . $filename;
        }

        if ($request->hasFile('og_image')) {
            if ($package && $package->og_image && File::exists(public_path($package->og_image))) {
                File::delete(public_path($package->og_image));
            }
            $file = $request->file('og_image');
            $filename = time() . '_og_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/packages'), $filename);
            $data['og_image'] = 'uploads/packages/' . $filename;
        }

        foreach (config('translatable.locales') as $locale) {
            if ($request->has($locale)) {
                $data[$locale] = [
                    'title'           => $request->input("$locale.title"),
                    'subtitle'        => $request->input("$locale.subtitle"),
                    'description'     => $request->input("$locale.description"),
                    'meta_title'       => $request->input("$locale.meta_title"),
                    'meta_description' => $request->input("$locale.meta_description"),
                    'meta_keywords'    => $request->input("$locale.meta_keywords"),
                ];
            }
        }

        return $data;
    }

    
}