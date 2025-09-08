<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FroalaHandlerController extends Controller
{
    public function uploadImage(Request $request)
    {
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
}
