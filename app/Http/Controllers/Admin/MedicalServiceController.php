<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MedicalService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MedicalServiceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = MedicalService::with('translations')->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('title', fn($row) =>
                    optional($row->translate())->title
                )
                ->addColumn('action', function($row) {
                    return '
                        <button class="btn btn-sm btn-info" id="EditBtn" rid="'.$row->id.'">Edit</button>
                        <button class="btn btn-sm btn-danger deleteBtn"
                            data-delete-url="'.route('admin.medical_services.destroy', $row->id).'"
                            data-table="#serviceTable">Delete</button>';
                })
                ->make(true);
        }

        return view('admin.medical_services.index');
    }

    public function store(Request $request)
    {
        $service = MedicalService::create([
            'icon' => $request->icon,
            'color' => $request->color,
            'order' => $request->order,
            'status' => 1,
        ]);

        foreach(config('translatable.locales') as $locale) {
            $service->translations()->create([
                'locale' => $locale,
                'title' => $request->$locale['title'],
                'description' => $request->$locale['description'],
                'features' => array_filter($request->$locale['features'] ?? [])
            ]);
        }

        return response()->json(['message' => 'Service created successfully!']);
    }

    public function edit($id)
    {
        return MedicalService::with('translations')->findOrFail($id);
    }

    public function update(Request $request)
    {
        $service = MedicalService::findOrFail($request->codeid);

        $service->update([
            'icon' => $request->icon,
            'color' => $request->color,
            'order' => $request->order,
        ]);

        foreach(config('translatable.locales') as $locale) {
            $service->translations()->updateOrCreate(
                ['locale' => $locale],
                [
                    'title' => $request->$locale['title'],
                    'description' => $request->$locale['description'],
                    'features' => array_filter($request->$locale['features'] ?? [])
                ]
            );
        }

        return response()->json(['message' => 'Service updated successfully!']);
    }

    public function destroy($id)
    {
        MedicalService::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted!']);
    }
}