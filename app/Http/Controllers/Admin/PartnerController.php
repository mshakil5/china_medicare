<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Partner;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Partner::orderBy('sort_order', 'asc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function($row) {
                    return '<img src="'.asset($row->image).'" width="100" class="img-thumbnail">';
                })
                ->addColumn('action', function($row) {
                    return '
                        <div class="dropdown">
                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown"><i class="ri-more-fill"></i></button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><button class="dropdown-item" id="EditBtn" rid="'.$row->id.'"><i class="ri-pencil-fill me-2 text-muted"></i> Edit</button></li>
                                <li><button class="dropdown-item deleteBtn" data-delete-url="'.route('partners.destroy', $row->id).'" data-table="#partnerTable"><i class="ri-delete-bin-fill me-2 text-muted"></i> Delete</button></li>
                            </ul>
                        </div>';
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }
        return view('admin.partners.index');
    }

    public function store(Request $request)
    {
        $request->validate(['image' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048']);
        
        $data = $request->only('link', 'sort_order');
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/partners'), $filename);
            $data['image'] = 'uploads/partners/' . $filename;
        }

        Partner::create($data);
        return response()->json(['message' => 'Partner logo added!']);
    }

    public function update(Request $request)
    {
        $partner = Partner::findOrFail($request->codeid);
        $data = $request->only('link', 'sort_order');

        if ($request->hasFile('image')) {
            if (File::exists(public_path($partner->image))) {
                File::delete(public_path($partner->image));
            }
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/partners'), $filename);
            $data['image'] = 'uploads/partners/' . $filename;
        }

        $partner->update($data);
        return response()->json(['message' => 'Partner updated successfully!']);
    }

    public function edit($id)
    {
        return Partner::findOrFail($id);
    }

    public function destroy($id)
    {
        $partner = Partner::findOrFail($id);
        if (File::exists(public_path($partner->image))) {
            File::delete(public_path($partner->image));
        }
        $partner->delete();
        return response()->json(['message' => 'Partner deleted!']);
    }
}
