<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HeroSection;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class HeroSectionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = HeroSection::with('translations')->latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function($row) {
                    return '<img src="'.asset($row->image).'" width="50" class="rounded">';
                })
                ->addColumn('title', function($row) {
                    return $row->translateOrNew(app()->getLocale())->title;
                })
                ->addColumn('action', function($row) {
                    return '
                        <div class="dropdown">
                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown"><i class="ri-more-fill"></i></button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><button class="dropdown-item" id="EditBtn" rid="'.$row->id.'"><i class="ri-pencil-fill me-2 text-muted"></i> Edit</button></li>
                                <li><button class="dropdown-item deleteBtn" data-delete-url="'.route('hero_sections.destroy', $row->id).'" data-table="#heroTable"><i class="ri-delete-bin-fill me-2 text-muted"></i> Delete</button></li>
                            </ul>
                        </div>';
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }
        return view('admin.hero_sections.index');
    }

    public function store(Request $request)
    {
        $data = $this->validateHero($request);
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            // This moves the file to public/uploads/hero/
            $file->move(public_path('uploads/hero'), $filename);
            $data['image'] = 'uploads/hero/' . $filename;
        }

        $data['stats'] = $this->formatStats($request);
        $data['info_cards'] = $this->formatInfoCards($request);

        HeroSection::create($data);
        return response()->json(['message' => 'Hero Section created successfully!']);
    }

    public function update(Request $request)
    {
        $hero = HeroSection::findOrFail($request->codeid);
        $data = $this->validateHero($request);

        if ($request->hasFile('image')) {
            // Delete old image if it exists in public folder
            if ($hero->image && File::exists(public_path($hero->image))) {
                File::delete(public_path($hero->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/hero'), $filename);
            $data['image'] = 'uploads/hero/' . $filename;
        }

        $data['stats'] = $this->formatStats($request);
        $data['info_cards'] = $this->formatInfoCards($request);

        $hero->update($data);
        return response()->json(['message' => 'Hero Section updated successfully!']);
    }

    public function edit($id)
    {
        return HeroSection::with('translations')->findOrFail($id);
    }



    public function destroy($id)
    {
        $hero = HeroSection::findOrFail($id);
        
        // Delete file from public folder
        if ($hero->image && File::exists(public_path($hero->image))) {
            File::delete(public_path($hero->image));
        }
        
        $hero->delete();
        return response()->json(['message' => 'Hero Section deleted successfully!']);
    }


    private function validateHero($request) {
        $rules = [
            'video_url' => 'nullable|url',
            'btn1_url' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules["$locale.title"] = 'required|string';
            $rules["$locale.badge"] = 'nullable|string';
            $rules["$locale.description"] = 'nullable|string';
            $rules["$locale.btn1_text"] = 'nullable|string';
        }
        return $request->validate($rules);
    }

    private function formatStats($request) {
        return [
            ['value' => $request->stat1_val, 'label' => $request->stat1_lbl],
            ['value' => $request->stat2_val, 'label' => $request->stat2_lbl],
            ['value' => $request->stat3_val, 'label' => $request->stat3_lbl],
        ];
    }

    private function formatInfoCards($request) {
        return [
            ['title' => $request->card1_title, 'sub' => $request->card1_sub],
            ['title' => $request->card2_title, 'sub' => $request->card2_sub],
        ];
    }
}
