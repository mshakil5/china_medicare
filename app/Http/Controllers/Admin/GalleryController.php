<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Gallery::latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('preview', function ($row) {
                    $badge = match($row->type) {
                        'youtube' => '<span class="badge bg-danger ms-1">YouTube</span>',
                        'video'   => '<span class="badge bg-warning text-dark ms-1">Video</span>',
                        default   => '<span class="badge bg-primary ms-1">Image</span>'
                    };
                    
                    $img = $row->preview_image;
                    return '<img src="/' . $img . '" width="60" class="img-thumbnail rounded" onerror="this.src=\'https://via.placeholder.com/60\'">' . $badge;
                })
                ->addColumn('status', function ($row) {
                    $checked = $row->status ? 'checked' : '';
                    return '<div class="form-check form-switch">
                                <input class="form-check-input status-toggle" type="checkbox"
                                    data-id="' . $row->id . '" ' . $checked . '>
                            </div>';
                })
                ->addColumn('action', function ($row) {
                    return '<button id="EditBtn" rid="' . $row->id . '" class="btn btn-sm btn-primary">Edit</button>
                            <button class="btn btn-sm btn-danger deleteBtn"
                                data-delete-url="' . route('galleries.destroy', $row->id) . '"
                                data-table="#galleryTable">Delete</button>';
                })
                ->rawColumns(['preview', 'status', 'action'])
                ->make(true);
        }

        return view('admin.galleries.index');
    }

    public function store(Request $request)
    {
        $rules = [
            'type'      => 'required|in:image,video,youtube',
            'title'     => 'required|string|max:255',
            'subtitle'  => 'nullable|string|max:255',
            'sort_order'=> 'nullable|integer|min:0',
        ];

        // Conditional validation
        if ($request->type === 'youtube') {
            $rules['video_link'] = 'required|url';
            $rules['file']       = 'nullable';
            $rules['thumbnail']  = 'nullable';
        } else {
            $rules['file'] = 'required|file|mimes:jpeg,png,jpg,gif,webp,mp4,mov,avi,mkv|max:51200';
            if ($request->type === 'video') {
                $rules['thumbnail'] = 'required|image|mimes:jpeg,png,jpg,webp|max:5120';
            } else {
                $rules['thumbnail'] = 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120';
            }
        }

        $request->validate($rules);

        $gallery = new Gallery();
        $this->saveData($gallery, $request);

        return response()->json(['message' => 'Gallery item added successfully!']);
    }

    public function edit($id)
    {
        return Gallery::findOrFail($id);
    }

    public function update(Request $request)
    {
        $rules = [
            'type'      => 'required|in:image,video,youtube',
            'title'     => 'required|string|max:255',
            'subtitle'  => 'nullable|string|max:255',
            'sort_order'=> 'nullable|integer|min:0',
        ];

        if ($request->type === 'youtube') {
            $rules['video_link'] = 'required|url';
            $rules['file']       = 'nullable';
            $rules['thumbnail']  = 'nullable';
        } else {
            $rules['file'] = 'nullable|file|mimes:jpeg,png,jpg,gif,webp,mp4,mov,avi,mkv|max:51200';
            $rules['thumbnail'] = 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120';
        }

        $request->validate($rules);

        $gallery = Gallery::findOrFail($request->codeid);
        $this->saveData($gallery, $request);

        return response()->json(['message' => 'Gallery item updated successfully!']);
    }

    // ✅ Reusable Save Logic
    private function saveData(Gallery $gallery, Request $request)
    {
        $gallery->type       = $request->type;
        $gallery->title      = $request->title;
        $gallery->subtitle   = $request->subtitle;
        $gallery->sort_order = $request->sort_order ?? 0;
        $gallery->status     = $request->has('status') ? 1 : 0;
        $gallery->video_link = $request->video_link ?? null;

        // Handle local file upload
        if ($request->hasFile('file')) {
            if ($gallery->file_path && File::exists(public_path($gallery->file_path))) {
                File::delete(public_path($gallery->file_path));
            }
            $file     = $request->file('file');
            $folder   = $gallery->type === 'video' ? 'uploads/gallery/videos' : 'uploads/gallery/images';
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($folder), $filename);
            $gallery->file_path = $folder . '/' . $filename;
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            if ($gallery->thumbnail && File::exists(public_path($gallery->thumbnail))) {
                File::delete(public_path($gallery->thumbnail));
            }
            $thumb = $request->file('thumbnail');
            $tname = time() . '_thumb.' . $thumb->getClientOriginalExtension();
            $thumb->move(public_path('uploads/gallery/thumbnails'), $tname);
            $gallery->thumbnail = 'uploads/gallery/thumbnails/' . $tname;
        }

        // If switched to YouTube, clear old local files to save space
        if ($request->type === 'youtube') {
            if ($gallery->file_path && File::exists(public_path($gallery->file_path))) {
                File::delete(public_path($gallery->file_path));
                $gallery->file_path = null;
            }
            if ($gallery->thumbnail && File::exists(public_path($gallery->thumbnail))) {
                File::delete(public_path($gallery->thumbnail));
                $gallery->thumbnail = null;
            }
        }

        $gallery->save();
    }

    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);

        if ($gallery->file_path && File::exists(public_path($gallery->file_path))) {
            File::delete(public_path($gallery->file_path));
        }
        if ($gallery->thumbnail && File::exists(public_path($gallery->thumbnail))) {
            File::delete(public_path($gallery->thumbnail));
        }

        $gallery->delete();

        return response()->json(['message' => 'Deleted successfully!']);
    }
}