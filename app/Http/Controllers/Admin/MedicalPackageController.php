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
                ->addColumn('title', fn($row) => $row->title)
                ->addColumn('action', function($row) {
                    return '<button class="btn btn-sm btn-info" id="EditBtn" rid="'.$row->id.'">Edit</button>
                            <button class="btn btn-sm btn-danger deleteBtn" data-delete-url="'.route('medical-packages.destroy', $row->id).'" data-table="#packageTable">Delete</button>';
                })
                ->make(true);
        }
        return view('admin.medical_packages.index');
    }

    public function store(Request $request) {
        $data = $this->validatePackage($request);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/packages'), $filename);
            $data['image'] = 'uploads/packages/' . $filename;
        }
        $data['is_popular'] = $request->has('is_popular');
        $data['is_featured'] = $request->has('is_featured');
        $data['features'] = array_filter($request->features ?? []); // Remove empty fields

        MedicalPackage::create($data);
        return response()->json(['message' => 'Package created successfully!']);
    }

    public function edit($id) {
        return MedicalPackage::with('translations')->findOrFail($id);
    }

    public function update(Request $request) {
        $pkg = MedicalPackage::findOrFail($request->codeid);
        $data = $this->validatePackage($request);

        if ($request->hasFile('image')) {
            if ($pkg->image && File::exists(public_path($pkg->image))) { File::delete(public_path($pkg->image)); }
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/packages'), $filename);
            $data['image'] = 'uploads/packages/' . $filename;
        }
        $data['is_popular'] = $request->has('is_popular');
        $data['is_featured'] = $request->has('is_featured');
        $data['features'] = array_filter($request->features ?? []);

        $pkg->update($data);
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
            'price_range' => 'required',
            'en.title' => 'required',
            'image' => 'nullable|image',
        ]);
    }
}

