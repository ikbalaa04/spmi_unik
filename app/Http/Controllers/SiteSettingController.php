<?php

namespace App\Http\Controllers;

use App\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SiteSettingController extends Controller
{
    public function media($filename)
    {
        if (!preg_match('/^[A-Za-z0-9._-]+$/', $filename)) {
            abort(404);
        }

        $path = storage_path('app/public/site-settings/' . $filename);

        if (!is_file($path)) {
            abort(404);
        }

        return response()->file($path, [
            'Cache-Control' => 'public, max-age=86400',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

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
            'about_title' => 'required|string|max:200',
            'about_description' => 'required|string|max:1500',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:4096',
            'banner_1' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:6144',
            'banner_2' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:6144',
            'banner_3' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:6144',
            'about_image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:6144',
        ]);

        $files = [
            'logo' => 'logo_path',
            'banner_1' => 'banner_1_path',
            'banner_2' => 'banner_2_path',
            'banner_3' => 'banner_3_path',
            'about_image' => 'about_image_path',
        ];

        $newFiles = [];
        $oldFiles = [];

        DB::beginTransaction();

        try {
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
                'about_title',
                'about_description',
            ]));

            foreach ($files as $input => $column) {
                if (!$request->hasFile($input)) {
                    continue;
                }

                $file = $request->file($input);

                if (!$file || !$file->isValid()) {
                    throw new \RuntimeException('File ' . $input . ' tidak valid atau gagal diunggah.');
                }

                $oldFiles[] = $settings->{$column};
                $settings->{$column} = $this->storeImage($file, $input);
                $newFiles[] = $settings->{$column};
            }

            $settings->save();
            DB::commit();

            foreach ($oldFiles as $oldPath) {
                $this->deleteManagedImage($oldPath);
            }
        } catch (\Throwable $exception) {
            DB::rollBack();

            foreach ($newFiles as $newPath) {
                $this->deleteManagedImage($newPath);
            }

            report($exception);

            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'upload' => 'Pengaturan gagal disimpan: ' . $this->safeErrorMessage($exception),
                ]);
        }

        return redirect()
            ->route('site-settings.edit')
            ->with('pesan', 'Identitas dan konten halaman home berhasil diperbarui.');
    }

    private function storeImage($file, $prefix)
    {
        Storage::disk('public')->makeDirectory('site-settings');

        $filename = $prefix . '-' . time() . '-' . bin2hex(random_bytes(4)) . '.' . $file->getClientOriginalExtension();
        $stored = Storage::disk('public')->putFileAs('site-settings', $file, $filename);

        if (!$stored) {
            throw new \RuntimeException('Gambar gagal disimpan. Periksa izin direktori storage.');
        }

        return 'storage/' . $stored;
    }

    private function deleteManagedImage($path)
    {
        if ($path && strpos($path, 'storage/site-settings/') === 0) {
            Storage::disk('public')->delete(substr($path, strlen('storage/')));
        }
    }

    private function safeErrorMessage(\Throwable $exception)
    {
        $message = $exception->getMessage();

        if (stripos($message, 'permission') !== false || stripos($message, 'writable') !== false) {
            return 'direktori storage tidak dapat ditulis oleh PHP.';
        }

        if (stripos($message, 'too large') !== false || stripos($message, 'upload') !== false) {
            return 'file tidak valid atau melebihi batas upload PHP.';
        }

        return 'periksa log aplikasi untuk detail teknis.';
    }
}
