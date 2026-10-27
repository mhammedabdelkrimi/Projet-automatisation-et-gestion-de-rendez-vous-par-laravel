<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bilan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BilanController extends Controller
{
    /**
     * Store a newly created bilan.
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_name' => 'required|string|max:255',
            'date' => 'required|date',
            'pathology' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'image' => 'required|string', // Base64 data URL
        ]);

        // Create Bilans directory if it doesn't exist
        $dirPath = public_path('images/Bilans');
        if (!File::exists($dirPath)) {
            File::makeDirectory($dirPath, 0755, true, true);
        }

        // Process base64 image data
        $imageData = $request->input('image');
        // Strip data:image/png;base64,
        if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
            $imageData = substr($imageData, strpos($imageData, ',') + 1);
            $type = strtolower($type[1]); // png, jpeg, etc.
            if (!in_array($type, ['png', 'jpg', 'jpeg'])) {
                return response()->json(['success' => false, 'message' => 'Format d\'image invalide.'], 400);
            }
            $imageData = base64_decode($imageData);
            if ($imageData === false) {
                return response()->json(['success' => false, 'message' => 'Échec du décodage de l\'image.'], 400);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Données d\'image invalides.'], 400);
        }

        $filename = 'bilan_' . time() . '_' . uniqid() . '.' . $type;
        $filePath = $dirPath . '/' . $filename;
        
        // Save file
        File::put($filePath, $imageData);

        // Save in database
        $bilan = Bilan::create([
            'patient_name' => $request->patient_name,
            'date' => $request->date,
            'pathology' => $request->pathology,
            'notes' => $request->notes,
            'image_path' => 'images/Bilans/' . $filename,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Le bilan a été enregistré avec succès.',
            'bilan' => $bilan
        ]);
    }

    /**
     * Remove the specified bilan.
     */
    public function destroy($id)
    {
        $bilan = Bilan::findOrFail($id);

        // Delete the physical file
        $filePath = public_path($bilan->image_path);
        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        $bilan->delete();

        return redirect()->back()->with('success', 'Le bilan a été supprimé avec succès.');
    }

    /**
     * Store a newly created diagnosis schema image.
     */
    public function storeSchema(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:4096',
            'name' => 'required|string|max:100',
        ]);
        //trim() enlève les espaces au début et à la fin.
        $name = trim($request->input('name'));
        // Clean name: replace spaces with underscores, remove special characters
        $cleanName = str_replace(' ', '_', $name);
        $cleanName = preg_replace('/[^A-Za-z0-9\_]/', '', $cleanName);
        $cleanName = strtolower($cleanName);

        $image = $request->file('image');
        $ext = strtolower($image->getClientOriginalExtension());
        
        $filename = $cleanName . '.' . $ext;
        
        $dirPath = public_path('images/Diagno');
        if (!File::exists($dirPath)) {
            File::makeDirectory($dirPath, 0755, true, true);
        }

        // Check if schema filename already exists
        $filePath = $dirPath . '/' . $filename;
        if (File::exists($filePath)) {
            return redirect()->back()->with('error', 'Un schéma avec ce nom existe déjà.');
        }

        $image->move($dirPath, $filename);

        return redirect()->back()->with('success', 'Le schéma a été ajouté avec succès.');
    }

    /**
     * Rename an existing schema image.
     */
    public function renameSchema(Request $request)
    {
        $request->validate([
            'old_filename' => 'required|string',
            'new_name' => 'required|string|max:100',
        ]);

        $oldFilename = basename($request->input('old_filename'));
        $oldFilePath = public_path('images/Diagno/' . $oldFilename);

        if (!File::exists($oldFilePath)) {
            return response()->json(['success' => false, 'message' => 'Le fichier schéma d\'origine n\'existe pas.'], 404);
        }

        $newName = trim($request->input('new_name'));
        $cleanNewName = str_replace(' ', '_', $newName);
        $cleanNewName = preg_replace('/[^A-Za-z0-9\_]/', '', $cleanNewName);
        $cleanNewName = strtolower($cleanNewName);

        $ext = strtolower(pathinfo($oldFilename, PATHINFO_EXTENSION));
        $newFilename = $cleanNewName . '.' . $ext;
        $newFilePath = public_path('images/Diagno/' . $newFilename);

        if (File::exists($newFilePath) && $newFilename !== $oldFilename) {
            return response()->json(['success' => false, 'message' => 'Un schéma avec ce nom existe déjà.'], 400);
        }

        rename($oldFilePath, $newFilePath);

        return response()->json([
            'success' => true,
            'message' => 'Le schéma a été renommé avec succès.',
            'new_filename' => $newFilename,
            'new_name' => $cleanNewName
        ]);
    }

    /**
     * Delete an existing schema image.
     */
    public function destroySchema(Request $request)
    {
        $request->validate([
            'filename' => 'required|string',
        ]);

        $filename = basename($request->input('filename'));
        $filePath = public_path('images/Diagno/' . $filename);

        if (!File::exists($filePath)) {
            return response()->json(['success' => false, 'message' => 'Le schéma n\'existe pas ou a déjà été supprimé.'], 404);
        }

        File::delete($filePath);

        return response()->json([
            'success' => true,
            'message' => 'Le schéma a été supprimé avec succès.'
        ]);
    }
}
