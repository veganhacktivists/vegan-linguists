<?php

namespace Tests\Feature\Models;

use App\Models\Comment;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->commentAuthor = User::factory()->create();

    $this->normalComments = Comment::factory(10)->create([
        'author_id' => $this->commentAuthor->id,
        'commentable_id' => 1,
        'commentable_type' => 'App\Models\TranslationRequest',
    ]);

    $this->unresolvedComments = Comment::factory(9)->create([
        'author_id' => $this->commentAuthor->id,
        'commentable_id' => 1,
        'commentable_type' => 'App\Models\TranslationRequest',
        'metadata' => [
            'annotation' => [
                'index' => 583,
                'length' => 368,
            ],
            'resolved_at' => null,
        ],
    ]);

    $this->resolvedComments = Comment::factory(8)->create([
        'author_id' => $this->commentAuthor->id,
        'commentable_id' => 1,
        'commentable_type' => 'App\Models\TranslationRequest',
        'metadata' => [
            'annotation' => [
                'index' => 583,
                'length' => 368,
            ],
            'resolved_at' => 1659381975,
        ],
    ]);
});

test('has annotation attribute', function () {
    $this->assertFalse($this->normalComments->first()->hasAnnotation());
    $this->assertTrue($this->unresolvedComments->first()->hasAnnotation());
    $this->assertTrue($this->resolvedComments->first()->hasAnnotation());
});

test('is resolved attribute', function () {
    $this->assertFalse($this->normalComments->first()->is_resolved);
    $this->assertFalse($this->unresolvedComments->first()->is_resolved);
    $this->assertTrue($this->resolvedComments->first()->is_resolved);
});

test('resolved at attribute', function () {
    $time = new CarbonImmutable('2022-06-02T16:23:39');

    $comment = Comment::factory()->make([
        'metadata' => [
            'annotation' => [
                'index' => 583,
                'length' => 368,
            ],
            'resolved_at' => $time->getTimestamp(),
        ],
    ]);

    $this->assertTrue($time->equalTo($comment->resolved_at));

    $this->assertNull(
        Comment::factory()->make(['metadata' => null])->resolved_at
    );
});

test('truncated text attribute', function () {
    $this->assertEquals(
        'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus id egestas enim, in fermentum et',
        Comment::factory()->make([
            'plain_text' =>
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus id egestas enim, in fermentum et',
        ])->truncated_text
    );

    $this->assertEquals(
        'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus id egestas enim, in fermentum …',
        Comment::factory()->make([
            'plain_text' =>
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus id egestas enim, in fermentum …',
        ])->truncated_text
    );
});

test('marking unresolved comment as resolved', function () {
    $comment = $this->unresolvedComments->first();

    $this->assertFalse($comment->is_resolved);

    $comment->markAsResolved();

    $this->assertTrue($comment->is_resolved);
});

test('marking resolved comment as resolved', function () {
    $comment = $this->resolvedComments->first();
    $originalResolvedAt = $comment->resolved_at;

    $comment->markAsResolved();

    $this->assertTrue($originalResolvedAt->equalTo($comment->resolved_at));
});

test('marking normal comment as resolved', function () {
    $comment = $this->normalComments->first();

    $comment->markAsResolved();

    $this->assertNull($comment->resolved_at);
});

test('resolved comment scope', function () {
    $this->assertCount(
        $this->resolvedComments->count(),
        Comment::resolved()->get()
    );
});

test('ordering resolved comments by resolve date (ascending)', function () {
    $earlierTime = new CarbonImmutable('2020-06-01T13:34:56');
    $laterTime = new CarbonImmutable('2030-06-01T13:34:56');

    Comment::factory()->create([
        'author_id' => $this->commentAuthor->id,
        'commentable_id' => 1,
        'commentable_type' => 'App\Models\TranslationRequest',
        'metadata' => [
            'annotation' => [
                'index' => 583,
                'length' => 368,
            ],
            'resolved_at' => $earlierTime->getTimestamp(),
        ],
    ]);

    Comment::factory()->create([
        'author_id' => $this->commentAuthor->id,
        'commentable_id' => 1,
        'commentable_type' => 'App\Models\TranslationRequest',
        'metadata' => [
            'annotation' => [
                'index' => 583,
                'length' => 368,
            ],
            'resolved_at' => $laterTime->getTimestamp(),
        ],
    ]);

    $comments = Comment::resolved()
        ->orderByResolveDate()
        ->get();

    $this->assertTrue($earlierTime->equalTo($comments->first()->resolved_at));
    $this->assertTrue($laterTime->equalTo($comments->last()->resolved_at));
});

test('ordering resolved comments by resolve date (descending)', function () {
    $earlierTime = new CarbonImmutable('2020-06-01T13:34:56');
    $laterTime = new CarbonImmutable('2030-06-01T13:34:56');

    Comment::factory()->create([
        'author_id' => $this->commentAuthor->id,
        'commentable_id' => 1,
        'commentable_type' => 'App\Models\TranslationRequest',
        'metadata' => [
            'annotation' => [
                'index' => 583,
                'length' => 368,
            ],
            'resolved_at' => $earlierTime->getTimestamp(),
        ],
    ]);

    Comment::factory()->create([
        'author_id' => $this->commentAuthor->id,
        'commentable_id' => 1,
        'commentable_type' => 'App\Models\TranslationRequest',
        'metadata' => [
            'annotation' => [
                'index' => 583,
                'length' => 368,
            ],
            'resolved_at' => $laterTime->getTimestamp(),
        ],
    ]);

    $comments = Comment::resolved()
        ->orderByResolveDate('desc')
        ->get();

    $this->assertTrue($laterTime->equalTo($comments->first()->resolved_at));
    $this->assertTrue($earlierTime->equalTo($comments->last()->resolved_at));
});
