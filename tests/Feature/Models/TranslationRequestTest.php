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
    $this->translator = User::factory()->create();

    $this->language = Language::create([
        'code' => 'es',
        'name' => 'Spanish',
        'native_name' => 'Español',
    ]);

    $this->source = Source::factory()->create([
        'author_id' => $this->author->id,
        'language_id' => $this->language->id,
    ]);
});

test('assigning a translation request to a translator', function () {
    $translationRequest = TranslationRequest::factory()->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'status' => TranslationRequestStatus::UNCLAIMED,
    ]);

    $this->assertEquals(
        TranslationRequestStatus::UNCLAIMED,
        $translationRequest->status
    );
    $this->assertNull($translationRequest->translator_id);

    $translationRequest->assignTo($this->translator);

    $this->assertEquals(
        TranslationRequestStatus::CLAIMED,
        $translationRequest->status
    );
    $this->assertEquals(
        $this->translator->id,
        $translationRequest->translator_id
    );
});

test('unassigning a translator from a translation request', function () {
    $translationRequest = TranslationRequest::factory()->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'translator_id' => $this->translator->id,
        'status' => TranslationRequestStatus::CLAIMED,
    ]);

    $this->assertEquals(
        TranslationRequestStatus::CLAIMED,
        $translationRequest->status
    );
    $this->assertEquals(
        $this->translator->id,
        $translationRequest->translator_id
    );

    $translationRequest->unclaim();

    $this->assertEquals(
        TranslationRequestStatus::UNCLAIMED,
        $translationRequest->status
    );
    $this->assertNull($translationRequest->translator_id);
});

test('status functions', function () {
    $unclaimedTranslationRequest = TranslationRequest::factory()->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'status' => TranslationRequestStatus::UNCLAIMED,
    ]);

    $this->assertTrue($unclaimedTranslationRequest->isUnclaimed());
    $this->assertFalse($unclaimedTranslationRequest->isClaimed());
    $this->assertFalse($unclaimedTranslationRequest->isUnderReview());
    $this->assertFalse($unclaimedTranslationRequest->isComplete());

    $claimedTranslationRequest = TranslationRequest::factory()->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'status' => TranslationRequestStatus::CLAIMED,
    ]);

    $this->assertFalse($claimedTranslationRequest->isUnclaimed());
    $this->assertTrue($claimedTranslationRequest->isClaimed());
    $this->assertFalse($claimedTranslationRequest->isUnderReview());
    $this->assertFalse($claimedTranslationRequest->isComplete());

    $underReviewTranslationRequest = TranslationRequest::factory()->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'status' => TranslationRequestStatus::UNDER_REVIEW,
    ]);

    $this->assertFalse($underReviewTranslationRequest->isUnclaimed());
    $this->assertFalse($underReviewTranslationRequest->isClaimed());
    $this->assertTrue($underReviewTranslationRequest->isUnderReview());
    $this->assertFalse($underReviewTranslationRequest->isComplete());

    $completeTranslationRequest = TranslationRequest::factory()->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'status' => TranslationRequestStatus::COMPLETE,
    ]);

    $this->assertFalse($completeTranslationRequest->isUnclaimed());
    $this->assertFalse($completeTranslationRequest->isClaimed());
    $this->assertFalse($completeTranslationRequest->isUnderReview());
    $this->assertTrue($completeTranslationRequest->isComplete());
});

test('submitting a translation request', function () {
    $translationRequestWithoutRequiredReview = TranslationRequest::factory()->create(
        [
            'source_id' => $this->source->id,
            'language_id' => $this->language->id,
            'translator_id' => $this->translator->id,
            'status' => TranslationRequestStatus::CLAIMED,
            'num_approvals_required' => 0,
        ]
    );

    $translationRequestWithoutRequiredReview->submit('content', 'plain text');
    $this->assertEquals(
        TranslationRequestStatus::COMPLETE,
        $translationRequestWithoutRequiredReview->status
    );

    $translationRequestWithRequiredReview = TranslationRequest::factory()->create(
        [
            'source_id' => $this->source->id,
            'language_id' => $this->language->id,
            'translator_id' => $this->translator->id,
            'status' => TranslationRequestStatus::CLAIMED,
            'num_approvals_required' => 1,
        ]
    );

    $translationRequestWithRequiredReview->submit('content', 'plain text');
    $this->assertEquals(
        TranslationRequestStatus::UNDER_REVIEW,
        $translationRequestWithRequiredReview->status
    );
});

test('adding a reviewer to a translation request', function () {
    $translationRequest = TranslationRequest::factory()->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'translator_id' => $this->translator->id,
        'status' => TranslationRequestStatus::UNDER_REVIEW,
        'num_approvals_required' => 1,
    ]);

    $this->assertCount(0, $translationRequest->reviewers);

    $reviewer = User::factory()->create();

    $translationRequest->addReviewer($reviewer);
    $translationRequest->refresh();

    $this->assertCount(1, $translationRequest->reviewers);
    $this->assertEquals(
        TranslationRequestStatus::UNDER_REVIEW,
        $translationRequest->status
    );
});

test('approving a translation request works for reviewer', function () {
    $translationRequest = TranslationRequest::factory()->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'translator_id' => $this->translator->id,
        'status' => TranslationRequestStatus::UNDER_REVIEW,
        'num_approvals_required' => 1,
    ]);

    $reviewer = User::factory()->create();
    $translationRequest->addReviewer($reviewer);
    $translationRequest->setApproval($reviewer);

    $this->assertEquals(
        TranslationRequestStatus::COMPLETE,
        $translationRequest->status
    );
});

test(
    'a review is not complete until the number of approvals is reached',
    function () {
        $translationRequest = TranslationRequest::factory()->create([
            'source_id' => $this->source->id,
            'language_id' => $this->language->id,
            'translator_id' => $this->translator->id,
            'status' => TranslationRequestStatus::UNDER_REVIEW,
            'num_approvals_required' => 2,
        ]);

        $reviewer = User::factory()->create();
        $translationRequest->addReviewer($reviewer);
        $translationRequest->setApproval($reviewer);

        $this->assertEquals(
            TranslationRequestStatus::UNDER_REVIEW,
            $translationRequest->status
        );

        $reviewer2 = User::factory()->create();
        $translationRequest->addReviewer($reviewer2);
        $translationRequest->setApproval($reviewer2);

        $this->assertEquals(
            TranslationRequestStatus::COMPLETE,
            $translationRequest->status
        );
    }
);

test(
    "approving a translation request doesn't work for non-reviewer",
    function () {
        $translationRequest = TranslationRequest::factory()->create([
            'source_id' => $this->source->id,
            'language_id' => $this->language->id,
            'translator_id' => $this->translator->id,
            'status' => TranslationRequestStatus::UNDER_REVIEW,
            'num_approvals_required' => 1,
        ]);

        $user = User::factory()->create();
        $translationRequest->setApproval($user);

        $this->assertEquals(
            TranslationRequestStatus::UNDER_REVIEW,
            $translationRequest->status
        );
    }
);

test('has been approved by', function () {
    $translationRequest = TranslationRequest::factory()->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'translator_id' => $this->translator->id,
        'status' => TranslationRequestStatus::UNDER_REVIEW,
        'num_approvals_required' => 2,
    ]);

    $reviewer = User::factory()->create();
    $this->assertFalse($translationRequest->hasBeenApprovedBy($reviewer));

    $translationRequest->addReviewer($reviewer);
    $this->assertFalse($translationRequest->hasBeenApprovedBy($reviewer));

    $translationRequest->setApproval($reviewer);
    $this->assertTrue($translationRequest->hasBeenApprovedBy($reviewer));
});

test('has reviewer', function () {
    $translationRequest = TranslationRequest::factory()->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'translator_id' => $this->translator->id,
        'status' => TranslationRequestStatus::UNDER_REVIEW,
        'num_approvals_required' => 2,
    ]);

    $reviewer = User::factory()->create();
    $this->assertFalse($translationRequest->hasReviewer($reviewer));

    $translationRequest->addReviewer($reviewer);
    $this->assertTrue($translationRequest->hasReviewer($reviewer));

    $translationRequest->setApproval($reviewer);
    $this->assertTrue($translationRequest->hasReviewer($reviewer));
});

test('num approvals attribute', function () {
    $translationRequest = TranslationRequest::factory()->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'translator_id' => $this->translator->id,
        'status' => TranslationRequestStatus::UNDER_REVIEW,
        'num_approvals_required' => 2,
    ]);

    $reviewer = User::factory()->create();
    $this->assertEquals(0, $translationRequest->num_approvals);

    $translationRequest->addReviewer($reviewer);
    $this->assertEquals(0, $translationRequest->num_approvals);

    $translationRequest->setApproval($reviewer);
    $this->assertEquals(1, $translationRequest->num_approvals);
});

test('num approvals remaining attribute', function () {
    $translationRequest = TranslationRequest::factory()->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'translator_id' => $this->translator->id,
        'status' => TranslationRequestStatus::UNDER_REVIEW,
        'num_approvals_required' => 2,
    ]);

    $reviewer = User::factory()->create();
    $this->assertEquals(2, $translationRequest->num_approvals_remaining);

    $translationRequest->addReviewer($reviewer);
    $this->assertEquals(2, $translationRequest->num_approvals_remaining);

    $translationRequest->setApproval($reviewer);
    $this->assertEquals(1, $translationRequest->num_approvals_remaining);
});

test('does need reviewers', function () {
    $translationRequest = TranslationRequest::factory()->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'translator_id' => $this->translator->id,
        'status' => TranslationRequestStatus::UNDER_REVIEW,
        'num_approvals_required' => 2,
    ]);

    $reviewer = User::factory()->create();
    $this->assertTrue($translationRequest->doesNeedReviewers());

    $translationRequest->addReviewer($reviewer);
    $this->assertTrue($translationRequest->doesNeedReviewers());

    $translationRequest->setApproval($reviewer);
    $this->assertTrue($translationRequest->doesNeedReviewers());

    $reviewer2 = User::factory()->create();
    $translationRequest->addReviewer($reviewer2);
    $this->assertFalse($translationRequest->doesNeedReviewers());
});

test('unclaimed scope', function () {
    $unclaimedTranslationRequests = TranslationRequest::factory(3)->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'status' => TranslationRequestStatus::UNCLAIMED,
    ]);

    TranslationRequest::factory(2)->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'status' => TranslationRequestStatus::CLAIMED,
    ]);

    TranslationRequest::factory(2)->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'status' => TranslationRequestStatus::UNDER_REVIEW,
    ]);

    TranslationRequest::factory(2)->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'status' => TranslationRequestStatus::COMPLETE,
    ]);

    $this->assertCount(
        $unclaimedTranslationRequests->count(),
        TranslationRequest::unclaimed()->get()
    );
});

test('needs reviewers scope', function () {
    TranslationRequest::factory(2)->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'translator_id' => $this->translator->id,
        'status' => TranslationRequestStatus::UNDER_REVIEW,
        'num_approvals_required' => 0,
    ]);

    $this->assertCount(0, TranslationRequest::needsReviewers()->get());

    $translationRequestsWithReviewers = TranslationRequest::factory(2)->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'translator_id' => $this->translator->id,
        'status' => TranslationRequestStatus::UNDER_REVIEW,
        'num_approvals_required' => 1,
    ]);
    $reviewer = User::factory()->create();
    $translationRequestsWithReviewers->each->addReviewer($reviewer);

    $this->assertCount(0, TranslationRequest::needsReviewers()->get());

    $translationRequestsNeedingReviewers = TranslationRequest::factory(
        3
    )->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'translator_id' => $this->translator->id,
        'status' => TranslationRequestStatus::UNDER_REVIEW,
        'num_approvals_required' => 2,
    ]);

    $this->assertCount(
        $translationRequestsNeedingReviewers->count(),
        TranslationRequest::needsReviewers()->get()
    );

    $translationRequestsNeedingReviewers->each->addReviewer($reviewer);

    $this->assertCount(
        $translationRequestsNeedingReviewers->count(),
        TranslationRequest::needsReviewers()->get()
    );
});

test('under review scope', function () {
    TranslationRequest::factory(2)->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'status' => TranslationRequestStatus::UNCLAIMED,
    ]);

    TranslationRequest::factory(2)->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'status' => TranslationRequestStatus::CLAIMED,
    ]);

    $underReviewTranslationRequests = TranslationRequest::factory(3)->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'status' => TranslationRequestStatus::UNDER_REVIEW,
    ]);

    TranslationRequest::factory(2)->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'status' => TranslationRequestStatus::COMPLETE,
    ]);

    $this->assertCount(
        $underReviewTranslationRequests->count(),
        TranslationRequest::underReview()->get()
    );
});

test('complete and incomplete scopes', function () {
    TranslationRequest::factory(3)->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'status' => TranslationRequestStatus::UNCLAIMED,
    ]);

    TranslationRequest::factory(3)->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'status' => TranslationRequestStatus::CLAIMED,
    ]);

    TranslationRequest::factory(3)->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'status' => TranslationRequestStatus::UNDER_REVIEW,
    ]);

    TranslationRequest::factory(2)->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'status' => TranslationRequestStatus::COMPLETE,
    ]);

    $this->assertCount(9, TranslationRequest::incomplete()->get());

    $this->assertCount(2, TranslationRequest::complete()->get());
});

test('excluding translator scope', function () {
    TranslationRequest::factory(2)->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'translator_id' => $this->translator->id,
        'status' => TranslationRequestStatus::UNDER_REVIEW,
        'num_approvals_required' => 0,
    ]);

    $this->assertCount(
        0,
        TranslationRequest::excludingTranslator($this->translator)->get()
    );

    TranslationRequest::factory(3)->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'status' => TranslationRequestStatus::UNCLAIMED,
        'num_approvals_required' => 0,
    ]);

    $this->assertCount(
        3,
        TranslationRequest::excludingTranslator($this->translator)->get()
    );

    TranslationRequest::factory(3)->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'translator_id' => User::factory()->create()->id,
        'status' => TranslationRequestStatus::UNDER_REVIEW,
        'num_approvals_required' => 1,
    ]);

    $this->assertCount(
        6,
        TranslationRequest::excludingTranslator($this->translator)->get()
    );

    TranslationRequest::factory(3)->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'translator_id' => User::factory()->create()->id,
        'status' => TranslationRequestStatus::COMPLETE,
        'num_approvals_required' => 0,
    ]);

    $this->assertCount(
        9,
        TranslationRequest::excludingTranslator($this->translator)->get()
    );
});

test('excluding reviewer scope', function () {
    $reviewer = User::factory()->create();

    TranslationRequest::factory(2)
        ->create([
            'source_id' => $this->source->id,
            'language_id' => $this->language->id,
            'translator_id' => $this->translator->id,
            'status' => TranslationRequestStatus::UNDER_REVIEW,
            'num_approvals_required' => 1,
        ])
        ->each->addReviewer($reviewer);

    $this->assertCount(
        0,
        TranslationRequest::excludingReviewer($reviewer)->get()
    );

    TranslationRequest::factory(2)->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'translator_id' => $this->translator->id,
        'status' => TranslationRequestStatus::UNDER_REVIEW,
        'num_approvals_required' => 1,
    ]);

    $this->assertCount(
        2,
        TranslationRequest::excludingReviewer($reviewer)->get()
    );

    TranslationRequest::factory(2)
        ->create([
            'source_id' => $this->source->id,
            'language_id' => $this->language->id,
            'translator_id' => $this->translator->id,
            'status' => TranslationRequestStatus::COMPLETE,
            'num_approvals_required' => 1,
        ])
        ->each->addReviewer($reviewer);

    $this->assertCount(
        2,
        TranslationRequest::excludingReviewer($reviewer)->get()
    );

    TranslationRequest::factory(2)->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'translator_id' => $this->translator->id,
        'status' => TranslationRequestStatus::COMPLETE,
        'num_approvals_required' => 1,
    ]);

    $this->assertCount(
        4,
        TranslationRequest::excludingReviewer($reviewer)->get()
    );
});

test('excluding source author scope', function () {
    $otherAuthor = User::factory()->create();

    TranslationRequest::factory(2)->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'status' => TranslationRequestStatus::UNCLAIMED,
    ]);

    $this->assertCount(
        0,
        TranslationRequest::excludingSourceAuthor($this->author)->get()
    );

    $this->assertCount(
        2,
        TranslationRequest::excludingSourceAuthor($otherAuthor)->get()
    );
});

test('where source language id scope', function () {
    $otherLanguage = Language::create([
        'code' => 'nl',
        'name' => 'Dutch',
        'native_name' => 'Nederlands',
    ]);

    // should be included
    TranslationRequest::factory(2)->create([
        'source_id' => $this->source->id,
        'language_id' => $otherLanguage->id,
        'status' => TranslationRequestStatus::UNCLAIMED,
    ]);

    // should be included
    $source2 = Source::factory()->create([
        'author_id' => $this->author->id,
        'language_id' => $this->language->id,
    ]);

    TranslationRequest::factory(2)->create([
        'source_id' => $source2->id,
        'language_id' => $otherLanguage->id,
        'status' => TranslationRequestStatus::UNCLAIMED,
    ]);

    // should be excluded
    $source3 = Source::factory()->create([
        'author_id' => $this->author->id,
        'language_id' => $otherLanguage->id,
    ]);

    TranslationRequest::factory(2)->create([
        'source_id' => $source3->id,
        'language_id' => $this->language->id,
        'status' => TranslationRequestStatus::UNCLAIMED,
    ]);

    $this->assertCount(
        4,
        TranslationRequest::whereSourceLanguageId($this->language->id)->get()
    );
});

test('where language id scope', function () {
    $otherLanguage = Language::create([
        'code' => 'nl',
        'name' => 'Dutch',
        'native_name' => 'Nederlands',
    ]);

    TranslationRequest::factory(2)->create([
        'source_id' => $this->source->id,
        'language_id' => $otherLanguage->id,
        'status' => TranslationRequestStatus::UNCLAIMED,
    ]);

    $this->assertCount(
        0,
        TranslationRequest::whereLanguageId($this->language->id)->get()
    );

    $this->assertCount(
        2,
        TranslationRequest::whereLanguageId($otherLanguage->id)->get()
    );
});

test('order by status', function () {
    TranslationRequest::factory()->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'status' => TranslationRequestStatus::UNCLAIMED,
    ]);

    TranslationRequest::factory()->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'status' => TranslationRequestStatus::COMPLETE,
    ]);

    TranslationRequest::factory()->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'status' => TranslationRequestStatus::UNDER_REVIEW,
    ]);

    TranslationRequest::factory()->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'status' => TranslationRequestStatus::CLAIMED,
    ]);

    $this->assertEquals(
        [
            TranslationRequestStatus::UNCLAIMED,
            TranslationRequestStatus::CLAIMED,
            TranslationRequestStatus::UNDER_REVIEW,
            TranslationRequestStatus::COMPLETE,
        ],
        TranslationRequest::orderByStatus('asc')
            ->get()
            ->pluck('status')
            ->toArray()
    );

    $this->assertEquals(
        [
            TranslationRequestStatus::COMPLETE,
            TranslationRequestStatus::UNDER_REVIEW,
            TranslationRequestStatus::CLAIMED,
            TranslationRequestStatus::UNCLAIMED,
        ],
        TranslationRequest::orderByStatus('desc')
            ->get()
            ->pluck('status')
            ->toArray()
    );
});

test('where created after scope', function () {
    $yesterday = new CarbonImmutable('-1 day');
    $tomorrow = new CarbonImmutable('+1 day');

    TranslationRequest::factory()->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'created_at' => $yesterday,
    ]);

    TranslationRequest::factory()->create([
        'source_id' => $this->source->id,
        'language_id' => $this->language->id,
        'created_at' => $tomorrow,
    ]);

    $this->assertCount(
        2,
        TranslationRequest::whereCreatedAfter(
            $yesterday->subtract(1, 'second')
        )->get()
    );

    $this->assertCount(
        1,
        TranslationRequest::whereCreatedAfter($yesterday)->get()
    );

    $this->assertCount(
        0,
        TranslationRequest::whereCreatedAfter($tomorrow)->get()
    );
});
