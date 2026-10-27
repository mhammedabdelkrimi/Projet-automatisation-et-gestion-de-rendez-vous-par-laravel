<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class PagesServicesController extends Controller
{
    /**
     * Display service sub-pages list.
     */
    public function index()
    {
        $services = Service::all();
        return view('admin', compact('services'));
    }

    /**
     * Customize a service sub-page details.
     */
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        if ($request->has('content_fr') && !$request->has('hero_title_fr')) {
            $service->content_fr = $request->content_fr;
            $service->content_ar = $request->content_ar;
            $service->save();
            return redirect()->route('admin.dashboard')
                ->with('success', 'Détails de la page de service mis à jour !');
        }

        $request->validate([
            'hero_title_fr' => 'nullable|string|max:255',
            'hero_title_ar' => 'nullable|string|max:255',
            'hero_image' => 'nullable|image|max:4096',
            'show_rdv_btn' => 'nullable|string',
            'blocks' => 'nullable|array',
        ]);

        $showRdv = $request->has('show_rdv_btn');

        // Parse existing additional_images
        $currentImages = is_string($service->additional_images) ? json_decode($service->additional_images, true) : $service->additional_images;
        if (!is_array($currentImages) && !is_object($currentImages)) {
            $currentImages = [];
        }
        $currentImages = (array) $currentImages;

        // Handle Hero Image
        if ($request->hasFile('hero_image')) {
            if (!empty($currentImages['hero'])) {
                @unlink(public_path('images/services/details/' . $currentImages['hero']));
            }
            $heroFile = $request->file('hero_image');
            $heroFilename = 'hero_' . time() . '_' . uniqid() . '.' . $heroFile->getClientOriginalExtension();
            $heroFile->move(public_path('images/services/details'), $heroFilename);
            $currentImages['hero'] = $heroFilename;
        }

        // Parse Blocks and save images
        $blocksFr = [];
        $blocksAr = [];
        $blockImages = [];

        $inputBlocks = $request->input('blocks', []);
        foreach ($inputBlocks as $idx => $b) {
            $blocksFr[] = [
                'title_fr' => $b['title_fr'] ?? '',
                'desc_fr' => $b['desc_fr'] ?? '',
            ];
            $blocksAr[] = [
                'title_ar' => $b['title_ar'] ?? '',
                'desc_ar' => $b['desc_ar'] ?? '',
            ];

            // Image handling
            $imgName = $b['existing_image'] ?? null;
            $fileKey = 'blocks_image_' . $idx;
            if ($request->hasFile($fileKey)) {
                if (!empty($imgName)) {
                    @unlink(public_path('images/services/details/' . $imgName));
                }
                $file = $request->file($fileKey);
                $imgName = 'block_' . $idx . '_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/services/details'), $imgName);
            }
            $blockImages[] = $imgName;
        }

        $currentImages['blocks'] = $blockImages;

        $service->content_fr = json_encode([
            'hero_title' => $request->hero_title_fr,
            'show_rdv_btn' => $showRdv,
            'blocks' => $blocksFr,
        ], JSON_UNESCAPED_UNICODE);

        $service->content_ar = json_encode([
            'hero_title' => $request->hero_title_ar,
            'show_rdv_btn' => $showRdv,
            'blocks' => $blocksAr,
        ], JSON_UNESCAPED_UNICODE);

        $service->additional_images = $currentImages;
        $service->save();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Détails de la page de service mis à jour !');
    }
}
