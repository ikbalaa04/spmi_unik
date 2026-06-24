<?php

namespace App\Http\Controllers;

use App\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteSettingController extends Controller
{
    public function edit()
    {
        return view('settings.site', [
            'settings' => SiteSetting::values(),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'system_name' => 'nullable|string|max:150',
            'campus_name' => 'required|string|max:200',
            'hero_1_title' => 'required|string|max:150',
            'hero_1_description' => 'required|string|max:1000',
            'hero_2_title' => 'required|string|max:150',
            'hero_2_description' => 'required|string|max:1000',
            'hero_3_title' => 'required|string|max:150',
            'hero_3_description' => 'required|string|max:1000',
            'feature_1_title' => 'required|string|max:100',
            'feature_1_description' => 'required|string|max:1000',
            'feature_2_title' => 'required|string|max:100',
            'feature_2_description' => 'required|string|max:1000',
            'feature_3_title' => 'required|string|max:100',
            'feature_3_description' => 'required|string|max:1000',
            'about_title' => 'required|string|max:200',
            'about_description' => 'required|string|max:1500',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:4096',
            'banner_1' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:6144',
            'banner_2' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:6144',
            'banner_3' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:6144',
            'about_image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:6144',
        ]);

        $settings = SiteSetting::query()->firstOrNew(['id' => 1]);
        $settings->fill($request->only([
            'system_name',
            'campus_name',
            'hero_1_title',
            'hero_1_description',
            'hero_2_title',
            'hero_2_description',
            'hero_3_title',
            'hero_3_description',
            'feature_1_title',
            'feature_1_description',
            'feature_2_title',
            'feature_2_description',
            'feature_3_title',
            'feature_3_description',
            'about_title',
            'about_description',
        ]));

        $files = [
            'logo' => 'logo_path',
            'banner_1' => 'banner_1_path',
            'banner_2' => 'banner_2_path',
            'banner_3' => 'banner_3_path',
            'about_image' => 'about_image_path',
        ];

        foreach ($files as $input => $column) {
            if ($request->hasFile($input)) {
                try {
                    $settings->{$column} = $this->storeImage(
                        $request->file($input),
                        $input,
                        $settings->{$column}
                    );
                } catch (\Throwable $exception) {
                    report($exception);

                    return redirect()
                        ->back()
                        ->withInput()
                        ->withErrors([
                            $input => 'Gambar gagal disimpan. Periksa ukuran file dan izin direktori storage.',
                        ]);
                }
            }
        }

        $settings->save();

        return redirect()
            ->route('site-settings.edit')
            ->with('pesan', 'Identitas dan konten halaman home berhasil diperbarui.');
    }

    private function storeImage($file, $prefix, $oldPath = null)
    {
        $filename = $prefix . '-' . time() . '-' . bin2hex(random_bytes(4)) . '.' . $file->getClientOriginalExtension();
        $stored = Storage::disk('public')->putFileAs('site-settings', $file, $filename);

        if (!$stored) {
            throw new \RuntimeException('Gambar gagal disimpan. Periksa izin direktori storage.');
        }

        if ($oldPath && strpos($oldPath, 'storage/site-settings/') === 0) {
            Storage::disk('public')->delete(substr($oldPath, strlen('storage/')));
        }

        return 'storage/' . $stored;
    }
}
