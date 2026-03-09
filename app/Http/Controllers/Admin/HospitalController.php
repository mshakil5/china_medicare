<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hospital;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class HospitalController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Hospital::with('translations')->latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function($row) {
                    return '<img src="'.asset($row->image).'" width="50" class="rounded">';
                })
                ->addColumn('name', function($row) {
                    return $row->translateOrNew(app()->getLocale())->name;
                })
                ->addColumn('action', function($row) {
                    return '
                        <div class="dropdown">
                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown"><i class="ri-more-fill"></i></button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><button class="dropdown-item" id="EditBtn" rid="'.$row->id.'"><i class="ri-pencil-fill me-2 text-muted"></i> Edit</button></li>
                                <li><button class="dropdown-item deleteBtn" data-delete-url="'.route('hospitals.destroy', $row->id).'" data-table="#hospitalTable"><i class="ri-delete-bin-fill me-2 text-muted"></i> Delete</button></li>
                            </ul>
                        </div>';
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }
        return view('admin.hospitals.index');
    }

    public function store(Request $request)
    {
        $data = $this->validateHospital($request);
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/hospitals'), $filename);
            $data['image'] = 'uploads/hospitals/' . $filename;
        }

        $data['slug'] = Str::slug($request->en['name']);
        Hospital::create($data);
        return response()->json(['message' => 'Hospital created successfully!']);
    }

    public function update(Request $request)
    {
        $hospital = Hospital::findOrFail($request->codeid);
        $data = $this->validateHospital($request);

        if ($request->hasFile('image')) {
            if ($hospital->image && File::exists(public_path($hospital->image))) {
                File::delete(public_path($hospital->image));
            }
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/hospitals'), $filename);
            $data['image'] = 'uploads/hospitals/' . $filename;
        }

        $data['slug'] = Str::slug($request->en['name']);
        $hospital->update($data);
        return response()->json(['message' => 'Hospital updated successfully!']);
    }

    public function edit($id)
    {
        return Hospital::with('translations')->findOrFail($id);
    }

    public function destroy($id)
    {
        $hospital = Hospital::findOrFail($id);
        if ($hospital->image && File::exists(public_path($hospital->image))) {
            File::delete(public_path($hospital->image));
        }
        $hospital->delete();
        return response()->json(['message' => 'Hospital deleted successfully!']);
    }

    private function validateHospital($request) {
        $rules = [
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.name"] = 'required|string';
            $rules["$locale.specialty"] = 'required|string';
        }
        return $request->validate($rules);
    }
}