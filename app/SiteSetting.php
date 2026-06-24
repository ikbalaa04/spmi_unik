<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'system_name',
        'campus_name',
        'logo_path',
        'banner_1_path',
        'banner_2_path',
        'banner_3_path',
        'about_image_path',
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
    ];

    public function setSystemNameAttribute($value)
    {
        $this->attributes['system_name'] = $value ?: '';
    }

    public static function defaults()
    {
        return [
            'system_name' => 'LPM Smart Sistem',
            'campus_name' => 'Nama Perguruan Tinggi',
            'logo_path' => 'home/img/favicon.png',
            'banner_1_path' => 'home/img/slide/slide-1.jpg',
            'banner_2_path' => 'home/img/slide/slide-2.jpg',
            'banner_3_path' => 'home/img/slide/slide-3.jpg',
            'about_image_path' => 'home/img/about.png',
            'hero_1_title' => 'LPM Smart Sistem',
            'hero_1_description' => 'Aplikasi berbasis web untuk pengelolaan dokumen akreditasi perguruan tinggi.',
            'hero_2_title' => 'Multiple Search',
            'hero_2_description' => 'Temukan dokumen secara cepat hingga ke subfolder berkas.',
            'hero_3_title' => 'Diagram Pencapaian',
            'hero_3_description' => 'Pantau pencapaian dan nilai asesmen setiap program studi.',
            'feature_1_title' => 'Efisien',
            'feature_1_description' => 'Penyimpanan dokumen terpusat membuat berkas lebih mudah dan aman dikelola.',
            'feature_2_title' => 'Cepat',
            'feature_2_description' => 'Berkas dapat ditemukan kembali dengan cepat saat proses validasi.',
            'feature_3_title' => 'Tepat',
            'feature_3_description' => 'Laporan pencapaian membantu stakeholder mengambil keputusan perbaikan mutu.',
            'about_title' => 'Sistem Penjaminan Mutu Internal',
            'about_description' => 'Memperbaiki tata kelola dokumen dan menyediakan simulasi pencapaian asesmen program studi.',
        ];
    }

    public static function values()
    {
        $defaults = static::defaults();

        try {
            $settings = static::query()->first();
        } catch (\Throwable $exception) {
            return $defaults;
        }

        if (!$settings) {
            return $defaults;
        }

        $values = $settings->toArray();

        foreach ($defaults as $key => $default) {
            if (!array_key_exists($key, $values) || $values[$key] === null) {
                $values[$key] = $default;
            }
        }

        return $values;
    }

    public static function imageUrl(array $settings, $key)
    {
        $defaults = static::defaults();
        $path = isset($settings[$key]) ? ltrim($settings[$key], '/') : null;

        if ($path && strpos($path, 'storage/site-settings/') === 0) {
            $filename = basename($path);
            $storedFile = storage_path('app/public/site-settings/' . $filename);

            if (is_file($storedFile)) {
                return route('site-settings.media', ['filename' => $filename]);
            }
        }

        if ($path && is_file(public_path($path))) {
            return asset($path);
        }

        return asset($defaults[$key]);
    }
}
