<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ScanController extends Controller
{
    public function index()
    {
        $imagePath = session('uploaded_image');
        return view('scan', ['analyzer' => (object)['picture' => $imagePath]]);
    }

    public function upload()
    {
        $imagePath = session('uploaded_image');
        return view('upload', ['analyzer' => (object)['picture' => $imagePath]]);
    }

    public function process(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $image = $request->file('image');

            // Save to storage
            $path = $image->store('uploads', 'public');
            session(['uploaded_image' => $path]);

            // Send image to Flask API
            $response = Http::attach(
                'image',
                file_get_contents($image->getRealPath()),
                $image->getClientOriginalName()
            )->post('http://127.0.0.1:5000/predict');

            if ($response->successful()) {
                $data = $response->json();
                return view('scan', ['data' => $data, 'analyzer' => (object)['picture' => $path]]);
            } else {
                Log::error('Flask API Error: ' . $response->body());
                return back()->withErrors(['error' => 'Failed to process image: ' . $response->body()]);
            }
        } catch (\Exception $e) {
            Log::error('Scan process error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'An error occurred while processing the image: ' . $e->getMessage()]);
        }
    }

    public function uploadProcess(Request $request)
    {
        try {
            // Check if we're using existing image
            if ($request->has('use_existing')) {
                $imagePath = session('uploaded_image');
                if (!$imagePath || !Storage::disk('public')->exists($imagePath)) {
                    return back()->withErrors(['error' => 'No existing image found']);
                }
                
                // Use existing image
                $fullPath = storage_path('app/public/' . $imagePath);
                $filename = basename($imagePath);
                
                // Send existing image to Flask API
                $response = Http::attach(
                    'image',
                    file_get_contents($fullPath),
                    $filename
                )->post('http://127.0.0.1:5000/predict');

                if ($response->successful()) {
                    $data = $response->json();
                    return view('upload', ['data' => $data, 'analyzer' => (object)['picture' => $imagePath]]);
                } else {
                    Log::error('Flask API Error: ' . $response->body());
                    return back()->withErrors(['error' => 'Failed to process image: ' . $response->body()]);
                }
            } else {
                // Handle new image upload
                $request->validate([
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                ]);

                $image = $request->file('image');

                // Save to storage
                $path = $image->store('uploads', 'public');
                session(['uploaded_image' => $path]);

                // Send image to Flask API
                $response = Http::attach(
                    'image',
                    file_get_contents($image->getRealPath()),
                    $image->getClientOriginalName()
                )->post('http://127.0.0.1:5000/predict');

                if ($response->successful()) {
                    $data = $response->json();
                    return view('upload', ['data' => $data, 'analyzer' => (object)['picture' => $path]]);
                } else {
                    Log::error('Flask API Error: ' . $response->body());
                    return back()->withErrors(['error' => 'Failed to process image: ' . $response->body()]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Upload process error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'An error occurred while processing the image: ' . $e->getMessage()]);
        }
    }
                

    public function removePicture()
    {
        $imagePath = session('uploaded_image');
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
        session()->forget('uploaded_image');
        return back()->with('success', 'Picture removed successfully.');
    }
}