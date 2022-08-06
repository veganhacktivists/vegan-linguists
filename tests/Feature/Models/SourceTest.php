<?php

namespace Tests\Feature\Models;

use App\Models\Language;
use App\Models\Source;
use App\Models\TranslationRequest;
use App\Models\TranslationRequestStatus;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->author = User::factory()->create();

    $this->language = Language::create([
        'code' => 'es',
        'name' => 'Spanish',
        'native_name' => 'Español',
    ]);
});

test('ownership', function () {
    $otherUser = User::factory()->create();

    $source = Source::factory()->create([
        'author_id' => $this->author->id,
        'language_id' => $this->language->id,
    ]);

    $this->assertTrue($source->isOwnedBy($this->author));
    $this->assertFalse($source->isOwnedBy($otherUser));
});

test('slug attribute', function () {
    $source = Source::factory()->create([
        'title' => 'This is the title',
        'author_id' => $this->author->id,
        'language_id' => $this->language->id,
    ]);

    $this->assertEquals('this-is-the-title', $source->slug);
});

test('number of completed translations', function () {
    $translator = User::factory()->create();
    $source = Source::factory()->create([
        'author_id' => $this->author->id,
        'language_id' => $this->language->id,
    ]);

    TranslationRequest::factory(5)->create([
        'source_id' => $source->id,
        'language_id' => $this->language->id,
        'translator_id' => $translator->id,
        'status' => TranslationRequestStatus::UNCLAIMED,
    ]);

    TranslationRequest::factory(4)->create([
        'source_id' => $source->id,
        'language_id' => $this->language->id,
        'translator_id' => $translator->id,
        'status' => TranslationRequestStatus::CLAIMED,
    ]);

    TranslationRequest::factory(3)->create([
        'source_id' => $source->id,
        'language_id' => $this->language->id,
        'translator_id' => $translator->id,
        'status' => TranslationRequestStatus::COMPLETE,
    ]);

    $this->assertEquals(3, $source->num_complete_translation_requests);
});

test('order by recency scope (ascending)', function () {
    $earliestSource = Source::factory()->create([
        'author_id' => $this->author->id,
        'language_id' => $this->language->id,
        'created_at' => new CarbonImmutable('-1 day'),
    ]);

    Source::factory()->create([
        'author_id' => $this->author->id,
        'language_id' => $this->language->id,
        'created_at' => new CarbonImmutable(''),
    ]);

    $latestSource = Source::factory()->create([
        'author_id' => $this->author->id,
        'language_id' => $this->language->id,
        'created_at' => new CarbonImmutable('+1 day'),
    ]);

    $sources = Source::orderByRecency('asc')->get();

    $this->assertEquals($earliestSource->id, $sources->first()->id);
    $this->assertEquals($latestSource->id, $sources->last()->id);
});

test('order by recency scope (descending)', function () {
    $earliestSource = Source::factory()->create([
        'author_id' => $this->author->id,
        'language_id' => $this->language->id,
        'created_at' => new CarbonImmutable('-1 day'),
    ]);

    Source::factory()->create([
        'author_id' => $this->author->id,
        'language_id' => $this->language->id,
        'created_at' => new CarbonImmutable(''),
    ]);

    $latestSource = Source::factory()->create([
        'author_id' => $this->author->id,
        'language_id' => $this->language->id,
        'created_at' => new CarbonImmutable('+1 day'),
    ]);

    $sources = Source::orderByRecency('desc')->get();

    $this->assertEquals($earliestSource->id, $sources->last()->id);
    $this->assertEquals($latestSource->id, $sources->first()->id);
});

test('complete scope', function () {
    $translator = User::factory()->create();
    $completeSource = Source::factory()->create([
        'author_id' => $this->author->id,
        'language_id' => $this->language->id,
    ]);

    TranslationRequest::factory(3)->create([
        'source_id' => $completeSource->id,
        'language_id' => $this->language->id,
        'translator_id' => $translator->id,
        'status' => TranslationRequestStatus::COMPLETE,
    ]);

    $incompleteSource = Source::factory()->create([
        'author_id' => $this->author->id,
        'language_id' => $this->language->id,
    ]);

    TranslationRequest::factory(1)->create([
        'source_id' => $incompleteSource->id,
        'language_id' => $this->language->id,
        'translator_id' => $translator->id,
        'status' => TranslationRequestStatus::UNDER_REVIEW,
    ]);

    TranslationRequest::factory(3)->create([
        'source_id' => $incompleteSource->id,
        'language_id' => $this->language->id,
        'translator_id' => $translator->id,
        'status' => TranslationRequestStatus::COMPLETE,
    ]);

    $completeSources = Source::complete()->get();

    $this->assertCount(1, $completeSources);
    $this->assertEquals($completeSource->id, $completeSources->first()->id);
});

test('incomplete scope', function () {
    $translator = User::factory()->create();
    $completeSource = Source::factory()->create([
        'author_id' => $this->author->id,
        'language_id' => $this->language->id,
    ]);

    TranslationRequest::factory(3)->create([
        'source_id' => $completeSource->id,
        'language_id' => $this->language->id,
        'translator_id' => $translator->id,
        'status' => TranslationRequestStatus::COMPLETE,
    ]);

    $incompleteSource = Source::factory()->create([
        'author_id' => $this->author->id,
        'language_id' => $this->language->id,
    ]);

    TranslationRequest::factory(1)->create([
        'source_id' => $incompleteSource->id,
        'language_id' => $this->language->id,
        'translator_id' => $translator->id,
        'status' => TranslationRequestStatus::UNDER_REVIEW,
    ]);

    TranslationRequest::factory(3)->create([
        'source_id' => $incompleteSource->id,
        'language_id' => $this->language->id,
        'translator_id' => $translator->id,
        'status' => TranslationRequestStatus::COMPLETE,
    ]);

    $incompleteSources = Source::incomplete()->get();

    $this->assertCount(1, $incompleteSources);
    $this->assertEquals($incompleteSource->id, $incompleteSources->first()->id);
});
