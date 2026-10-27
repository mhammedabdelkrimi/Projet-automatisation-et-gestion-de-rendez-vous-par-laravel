<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ServicesController extends Controller
{
    /**
     * Store a new service in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
            'title_fr' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'desc_fr' => 'required|string',
            'desc_ar' => 'required|string',
            'phase' => 'required|integer|in:1,2,3',
        ]);

        $service = new Service();
        $service->title_fr = $request->title_fr;
        $service->title_ar = $request->title_ar;
        $service->desc_fr = $request->desc_fr;
        $service->desc_ar = $request->desc_ar;
        $service->phase = $request->phase;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $ext = strtolower($image->getClientOriginalExtension());
            
            // Calculate next position dynamically
            $position = Service::where('phase', $request->phase)->count() + 1;
            $filename = 'service_' . $request->phase . '_' . $position . '.' . $ext;

            $image->move(public_path('images/services'), $filename);
            $service->image = $filename;
        }

        $service->save();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Service ajouté avec succès !');
    }

    /**
     * Update an existing service in the database.
     */
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $request->validate([
            'image' => 'nullable|image|max:2048',
            'title_fr' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'desc_fr' => 'required|string',
            'desc_ar' => 'required|string',
            'phase' => 'required|integer|in:1,2,3',
        ]);

        $service->title_fr = $request->title_fr;
        $service->title_ar = $request->title_ar;
        $service->desc_fr = $request->desc_fr;
        $service->desc_ar = $request->desc_ar;
        $service->phase = $request->phase;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $newExt = strtolower($image->getClientOriginalExtension());
            $oldFilename = $service->image;

            if ($oldFilename && strpos($oldFilename, 'service_') === 0) {
                $baseName = pathinfo($oldFilename, PATHINFO_FILENAME);
            } else {
                $position = Service::where('phase', $service->phase)
                    ->where('id', '<=', $service->id)
                    ->count();
                $baseName = 'service_' . $service->phase . '_' . $position;
            }

            $filename = $baseName . '.' . $newExt;

            // Delete old file if extension changed
            if ($oldFilename && $oldFilename !== $filename) {
                $oldImagePath = public_path('images/services/' . $oldFilename);
                if (File::exists($oldImagePath)) {
                    @unlink($oldImagePath);
                }
            }

            // Force delete new path if it exists before moving to avoid conflict
            $newImagePath = public_path('images/services/' . $filename);
            if (File::exists($newImagePath)) {
                @unlink($newImagePath);
            }

            $image->move(public_path('images/services'), $filename);
            $service->image = $filename;
        }

        $service->save();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Service mis à jour avec succès !');
    }

    /**
     * Delete a service from the database.
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);

        // Delete the image file if it exists
        $imagePath = public_path('images/services/' . $service->image);
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        $service->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Service supprimé avec succès !');
    }

    /**
     * Update only the image of a service via AJAX.
     */
    public function updateImage(Request $request, $id)
    {
        try {
            $service = Service::find($id);
            if (!$service) {
                return response()->json([
                    'success' => false,
                    'message' => 'Service introuvable.'
                ], 404);
            }

            $currentImage = $service->image;
            
            if (!empty($currentImage) && strpos($currentImage, 'service_') === 0) {
                // Extract base filename without extension
                $baseName = pathinfo($currentImage, PATHINFO_FILENAME); // e.g. service_2_4
            } else {
                // Construct service_{phase}_{position} if the filename is random (like 1782993790_6a46537ecf6f0) or empty
                $phase = $service->phase;
                if (is_null($phase)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'La colonne phase est manquante ou nulle.'
                    ], 400);
                }
                
                // Calculate position dynamically as 1-based order in phase
                $position = Service::where('phase', $phase)
                    ->where('id', '<=', $service->id)
                    ->count();
                
                $baseName = 'service_' . $phase . '_' . $position;
            }

            // Check if file is uploaded
            if (!$request->hasFile('image') || !$request->file('image')->isValid()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Fichier d\'image non reçu ou invalide.'
                ], 400);
            }

            $file = $request->file('image');

            // Verify MIME type using PHP Fileinfo (reads magic bytes, not just extension)
            $mimeType = $file->getMimeType();
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($mimeType, $allowedMimeTypes)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Type de fichier non autorisé. Types MIME acceptés : JPEG, PNG, GIF, WEBP.'
                ], 400);
            }

            // Verify original file extension
            $extension = strtolower($file->getClientOriginalExtension());
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if (!in_array($extension, $allowedExtensions)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Extension de fichier non autorisée.'
                ], 400);
            }

            // Normalize filename
            $newFilename = $baseName . '.' . $extension;
            $targetDir = public_path('images/services');

            // Delete old file if extension changed
            if ($currentImage !== $newFilename) {
                $oldPath = $targetDir . '/' . $currentImage;
                if (File::exists($oldPath)) {
                    @unlink($oldPath);
                }
            }

            // Force delete new path if it exists before moving to avoid conflict
            $newPath = $targetDir . '/' . $newFilename;
            if (File::exists($newPath)) {
                @unlink($newPath);
            }

            // Move file
            $file->move($targetDir, $newFilename);

            // Update only the image column in database
            $service->image = $newFilename;
            $service->save();

            // Return success JSON response with cache-busting URL
            return response()->json([
                'success' => true,
                'message' => 'Image du service mise à jour avec succès.',
                'filename' => $newFilename,
                'url' => asset('images/services/' . $newFilename) . '?v=' . time()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de l\'enregistrement : ' . $e->getMessage()
            ], 500);
        }
    }
}
