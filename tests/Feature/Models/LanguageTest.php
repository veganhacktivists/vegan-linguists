<?php

namespace Tests\Feature\Models;

use App\Models\Language;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('full name attribute', function () {
    $this->assertEquals(
        'Spanish (Español)',
        (new Language([
            'name' => 'Spanish',
            'native_name' => 'Español',
        ]))->full_name
    );
});

test('ordering by name', function () {
    Language::create([
        'code' => 'es',
        'name' => 'Spanish',
        'native_name' => 'Español',
    ]);
    Language::create([
        'code' => 'en',
        'name' => 'English',
        'native_name' => 'English',
    ]);
    Language::create([
        'code' => 'zh_HANS',
        'name' => 'Chinese - Simplified',
        'native_name' => '中文 - 简体',
    ]);
    Language::create([
        'code' => 'ar',
        'name' => 'Arabic',
        'native_name' => 'العربية',
    ]);

    $this->assertEquals(
        ['Arabic', 'Chinese - Simplified', 'English', 'Spanish'],
        Language::orderByName('asc')
            ->get()
            ->pluck('name')
            ->toArray()
    );

    $this->assertEquals(
        ['Spanish', 'English', 'Chinese - Simplified', 'Arabic'],
        Language::orderByName('desc')
            ->get()
            ->pluck('name')
            ->toArray()
    );
});
