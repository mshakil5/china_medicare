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
                    $img = $row->preview_image;
                    $badge = $row->type === 'video'
                        ? '<span class="badge bg-danger ms-1">Video</span>'
                        : '<span class="badge bg-primary ms-1">Image</span>';
                    return '<img src="/' . $img . '" width="60" class="img-thumbnail rounded">' . $badge;
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
        $request->validate([
            'type'      => 'required|in:image,video',
            'title'     => 'required|string|max:255',
            'file'      => 'required|file|mimes:jpeg,png,jpg,gif,webp,mp4,mov,avi,mkv|max:51200',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $gallery = new Gallery();
        $gallery->type      = $request->type;
        $gallery->title     = $request->title;
        $gallery->subtitle  = $request->subtitle;
        $gallery->sort_order = $request->sort_order ?? 0;
        $gallery->status    = $request->has('status') ? 1 : 0;

        // Upload main file (image or video)
        if ($request->hasFile('file')) {
            $file     = $request->file('file');
            $folder   = $gallery->type === 'video' ? 'uploads/gallery/videos' : 'uploads/gallery/images';
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($folder), $filename);
            $gallery->file_path = $folder . '/' . $filename;
        }

        // Upload thumbnail (required for video, optional for image)
        if ($request->hasFile('thumbnail')) {
            $thumb    = $request->file('thumbnail');
            $tname    = time() . '_thumb.' . $thumb->getClientOriginalExtension();
            $thumb->move(public_path('uploads/gallery/thumbnails'), $tname);
            $gallery->thumbnail = 'uploads/gallery/thumbnails/' . $tname;
        }

        $gallery->save();

        return response()->json(['message' => 'Gallery item added successfully!']);
    }

    public function edit($id)
    {
        return Gallery::findOrFail($id);
    }

    public function update(Request $request)
    {
        $request->validate([
            'type'      => 'required|in:image,video',
            'title'     => 'required|string|max:255',
            'file'      => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,mp4,mov,avi,mkv|max:51200',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $gallery = Gallery::findOrFail($request->codeid);
        $gallery->type      = $request->type;
        $gallery->title     = $request->title;
        $gallery->subtitle  = $request->subtitle;
        $gallery->sort_order = $request->sort_order ?? 0;
        $gallery->status    = $request->has('status') ? 1 : 0;

        // Replace main file if new one uploaded
        if ($request->hasFile('file')) {
            if (File::exists(public_path($gallery->file_path))) {
                File::delete(public_path($gallery->file_path));
            }
            $file     = $request->file('file');
            $folder   = $gallery->type === 'video' ? 'uploads/gallery/videos' : 'uploads/gallery/images';
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($folder), $filename);
            $gallery->file_path = $folder . '/' . $filename;
        }

        // Replace thumbnail if new one uploaded
        if ($request->hasFile('thumbnail')) {
            if ($gallery->thumbnail && File::exists(public_path($gallery->thumbnail))) {
                File::delete(public_path($gallery->thumbnail));
            }
            $thumb = $request->file('thumbnail');
            $tname = time() . '_thumb.' . $thumb->getClientOriginalExtension();
            $thumb->move(public_path('uploads/gallery/thumbnails'), $tname);
            $gallery->thumbnail = 'uploads/gallery/thumbnails/' . $tname;
        }

        $gallery->save();

        return response()->json(['message' => 'Gallery item updated successfully!']);
    }

    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);

        if (File::exists(public_path($gallery->file_path))) {
            File::delete(public_path($gallery->file_path));
        }
        if ($gallery->thumbnail && File::exists(public_path($gallery->thumbnail))) {
            File::delete(public_path($gallery->thumbnail));
        }

        $gallery->delete();

        return response()->json(['message' => 'Deleted successfully!']);
    }
}