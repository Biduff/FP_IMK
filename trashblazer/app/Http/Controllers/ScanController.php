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
        // No changes here
        $imagePath = session('uploaded_image');
        return view('scan', ['analyzer' => (object)['picture' => $imagePath]]);
    }

    public function upload()
    {
        // No changes here
        $imagePath = session('uploaded_image');
        return view('upload', ['analyzer' => (object)['picture' => $imagePath]]);
    }

    public function process(Request $request)
    {
        // No changes here
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $image = $request->file('image');
            $path = $image->store('uploads', 'public');
            session(['uploaded_image' => $path]);

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
        // No changes here
        try {
            if ($request->has('use_existing')) {
                $imagePath = session('uploaded_image');
                if (!$imagePath || !Storage::disk('public')->exists($imagePath)) {
                    return back()->withErrors(['error' => 'No existing image found']);
                }
                
                $fullPath = storage_path('app/public/' . $imagePath);
                $filename = basename($imagePath);
                
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
                $request->validate([
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                ]);

                $image = $request->file('image');
                $path = $image->store('uploads', 'public');
                session(['uploaded_image' => $path]);

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
    
    /**
     * NEW METHOD
     * Removes the current picture and redirects to the upload page for a new session.
     */
    public function startNewUpload()
    {
        $imagePath = session('uploaded_image');
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
        session()->forget('uploaded_image');
        
        // Redirect to the clean upload page
        return redirect()->route('upload');
    }

    public function removePicture()
    {
        // No changes here, but the logic is now shared with the new method
        $imagePath = session('uploaded_image');
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
        session()->forget('uploaded_image');
        return back()->with('success', 'Picture removed successfully.');
    }
}