<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MedicalPackage;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;

class MedicalPackageController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = MedicalPackage::with('translations')->latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('title', function($row) {
                    return $row->translate('en')->title ?? 'N/A';
                })
                ->addColumn('action', function($row) {
                    return '<button class="btn btn-sm btn-info" id="EditBtn" rid="'.$row->id.'">Edit</button>
                            <button class="btn btn-sm btn-danger deleteBtn" data-delete-url="'.route('medical-packages.destroy', $row->id).'" data-table="#packageTable">Delete</button>';
                })
                ->make(true);
        }
        return view('admin.medical_packages.index');
    }

    public function store(Request $request) {
        // 1. Separate the main package data
        $data = [
            'category'     => $request->category,
            'duration'     => $request->duration,
            'cities_count' => $request->cities_count,
            'price_range'  => $request->price_range,
            'is_popular'   => $request->has('is_popular'),
            'is_featured'  => $request->has('is_featured'),
            'features'     => array_filter($request->features ?? []),
        ];

        // 2. Handle Image
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/packages'), $filename);
            $data['image'] = 'uploads/packages/' . $filename;
        }

        // 3. Attach Translations (Crucial Step)
        foreach (config('translatable.locales') as $locale) {
            // This looks for $request->en['title'], $request->bn['title'], etc.
            if ($request->has($locale)) {
                $data[$locale] = $request->input($locale);
            }
        }

        // Now Translatable will automatically pick up $data['en'] and $data['bn']
        MedicalPackage::create($data);

        return response()->json(['message' => 'Package created successfully!']);
    }

    
    public function edit($id) {
        return MedicalPackage::with('translations')->findOrFail($id);
    }

    public function update(Request $request) {
        
        $package = MedicalPackage::findOrFail($request->codeid);

        $data = [
            'category'     => $request->category,
            'duration'     => $request->duration,
            'cities_count' => $request->cities_count,
            'price_range'  => $request->price_range,
            'is_popular'   => $request->has('is_popular'),
            'is_featured'  => $request->has('is_featured'),
            'features'     => array_filter($request->features ?? []),
        ];

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($package->image && file_exists(public_path($package->image))) {
                unlink(public_path($package->image));
            }
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/packages'), $filename);
            $data['image'] = 'uploads/packages/' . $filename;
        }

        foreach (config('translatable.locales') as $locale) {
            if ($request->has($locale)) {
                $data[$locale] = $request->input($locale);
            }
        }

        $package->update($data);

        return response()->json(['message' => 'Package updated successfully!']);
    }

    public function destroy($id) {
        $pkg = MedicalPackage::findOrFail($id);
        if ($pkg->image && File::exists(public_path($pkg->image))) { File::delete(public_path($pkg->image)); }
        $pkg->delete();
        return response()->json(['message' => 'Deleted!']);
    }

    private function validatePackage($request) {
        return $request->validate([
            'category' => 'required',
            'duration' => 'required',
            'price_range' => 'nullable',
            'en.title' => 'required',
            'image' => 'nullable|image',
        ]);
    }
}

