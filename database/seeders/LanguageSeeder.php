<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    public function run()
    {
        $languages = [
            [
                'code' => 'ar',
                'name' => 'Arabic',
                'native_name' => 'العربية',
            ],
            [
                'code' => 'zh_HANS',
                'name' => 'Chinese - Simplified',
                'native_name' => '中文 - 简体',
            ],
            [
                'code' => 'zh_HANT',
                'name' => 'Chinese - Traditional',
                'native_name' => '中文 - 繁體',
            ],
            [
                'code' => 'en',
                'name' => 'English',
                'native_name' => 'English',
            ],
            [
                'code' => 'fr',
                'name' => 'French',
                'native_name' => 'Français',
            ],
            [
                'code' => 'de',
                'name' => 'German',
                'native_name' => 'Deutsch',
            ],
            [
                'code' => 'he',
                'name' => 'Hebrew',
                'native_name' => 'עברית',
            ],
            [
                'code' => 'hi',
                'name' => 'Hindi',
                'native_name' => 'हिन्दी, हिंदी',
            ],
            [
                'code' => 'it',
                'name' => 'Italian',
                'native_name' => 'Italiano',
            ],
            [
                'code' => 'ja',
                'name' => 'Japanese',
                'native_name' => '日本語',
            ],
            [
                'code' => 'ko',
                'name' => 'Korean',
                'native_name' => '한국어',
            ],
            [
                'code' => 'fa',
                'name' => 'Persian',
                'native_name' => 'فارسی',
            ],
            [
                'code' => 'pl',
                'name' => 'Polish',
                'native_name' => 'Polski',
            ],
            [
                'code' => 'pt',
                'name' => 'Portuguese',
                'native_name' => 'Português',
            ],
            [
                'code' => 'ru',
                'name' => 'Russian',
                'native_name' => 'Русский',
            ],
            [
                'code' => 'es',
                'name' => 'Spanish',
                'native_name' => 'Español',
            ],
            [
                'code' => 'th',
                'name' => 'Thai',
                'native_name' => 'ไทย',
            ],
            [
                'code' => 'vi',
                'name' => 'Vietnamese',
                'native_name' => 'Tiếng Việt',
            ],
        ];

        foreach ($languages as $language) {
            Language::create($language);
        }
    }
}
