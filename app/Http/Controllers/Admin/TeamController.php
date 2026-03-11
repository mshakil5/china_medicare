<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
use yajra\Datatables\Datatables;

class TeamController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Team::orderBy('order', 'asc');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function($row) {
                    return '<img src="'.asset($row->image).'" width="50" class="rounded">';
                })
                ->addColumn('action', function($row) {
                    return '<button class="btn btn-sm btn-info" id="EditBtn" rid="'.$row->id.'">Edit</button>
                            <button class="btn btn-sm btn-danger deleteBtn" data-delete-url="'.route('team.destroy', $row->id).'" data-table="#teamTable">Delete</button>';
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }
        return view('admin.team.index');
    }

    public function store(Request $request) {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/team'), $filename);
            $data['image'] = 'uploads/team/' . $filename;
        }
        Team::create($data);
        return response()->json(['message' => 'Team member added successfully!']);
    }

    public function store2(Request $request) {
        $data = $request->validate([
            'name' => 'required',
            'designation' => 'required',
            'image' => 'nullable|image'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/team'), $filename);
            $data['image'] = 'uploads/team/' . $filename;
        }
        
        $data['linkedin'] = $request->linkedin;
        $data['email'] = $request->email;
        $data['specialty'] = $request->specialty;

        Team::create($data);
        return response()->json(['message' => 'Member added!']);
    }

    public function edit($id) {
        return response()->json(Team::findOrFail($id));
    }

    public function update(Request $request) {
        $member = Team::findOrFail($request->codeid);
        $data = $request->all();
        
        if ($request->hasFile('image')) {
            if ($member->image && file_exists(public_path($member->image))) {
                unlink(public_path($member->image));
            }
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/team'), $filename);
            $data['image'] = 'uploads/team/' . $filename;
        }
        
        $member->update($data);
        return response()->json(['message' => 'Team member updated successfully!']);
    }

    public function destroy($id) {
        $member = Team::findOrFail($id);
        if ($member->image && file_exists(public_path($member->image))) {
            unlink(public_path($member->image));
        }
        $member->delete();
        return response()->json(['message' => 'Member deleted!']);
    }
}
