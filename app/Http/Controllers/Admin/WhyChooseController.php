<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WhyChoose;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class WhyChooseController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = WhyChoose::with('translations')->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('title', fn($row) =>
                    optional($row->translate())->title
                )
                ->addColumn('icon', fn($row) => $row->icon)
                ->addColumn('serial', fn($row) => $row->serial)
                ->addColumn('status', fn($row) =>
                    $row->status ? 'Active' : 'Inactive'
                )
                ->addColumn('action', function($row) {
                    return '
                        <button class="btn btn-sm btn-info" id="EditBtn" rid="'.$row->id.'">Edit</button>
                        <button class="btn btn-sm btn-danger deleteBtn"
                            data-delete-url="'.route('admin.why_choose.destroy', $row->id).'"
                            data-table="#whyChooseTable">Delete</button>';
                })
                ->make(true);
        }

        return view('admin.why_choose.index');
    }

    public function store(Request $request)
    {
        $why = WhyChoose::create([
            'icon' => $request->icon,
            'serial' => $request->serial,
            'status' => $request->status ?? 1,
        ]);

        foreach(config('translatable.locales') as $locale) {
            $why->translations()->create([
                'locale' => $locale,
                'title' => $request->$locale['title'],
                'description' => $request->$locale['description'],
            ]);
        }

        return response()->json(['message' => 'Why Choose item created successfully!']);
    }

    public function edit($id)
    {
        return WhyChoose::with('translations')->findOrFail($id);
    }

    public function update(Request $request)
    {
        $why = WhyChoose::findOrFail($request->codeid);

        $why->update([
            'icon' => $request->icon,
            'serial' => $request->serial,
            'status' => $request->status ?? 1,
        ]);

        foreach(config('translatable.locales') as $locale) {
            $why->translations()->updateOrCreate(
                ['locale' => $locale],
                [
                    'title' => $request->$locale['title'],
                    'description' => $request->$locale['description'],
                ]
            );
        }

        return response()->json(['message' => 'Why Choose updated successfully!']);
    }

    public function destroy($id)
    {
        WhyChoose::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted!']);
    }
}