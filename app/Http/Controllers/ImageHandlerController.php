<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageHandlerController extends Controller
{
    public function uploadImage(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|image|max:2048|mimes:png,jpg' // max 2MB
        ]);
        if ($request->hasFile('file')) {  // Froala kirim dengan key 'file'
            $path = $request->file('file')->store('reply', 'public');

            return response()->json([
                'link' => asset('storage/' . $path) // Froala butuh key 'link'
            ]);
        }
        return response()->json(['error' => 'No file uploaded'], 400);
    }

    public function deleteImage(Request $request)
    {
        $src = $request->input('src');
        if ($src) {
            // ambil path relatif
            $path = str_replace(asset('storage/') . '/', '', $src);

            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
                return response()->json(['status' => 'success']);
            }
        }
        return response()->json(['status' => 'file not found'], 404);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();

            // Store in public/images directory
            $path = $image->storeAs('images', $imageName, 'public');

            // Return the URL for TinyMCE
            return response()->json([
                'location' => Storage::url($path)
            ]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
