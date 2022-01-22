<?php

namespace App\Models;

abstract class TranslationRequestStatus
{
    const UNCLAIMED = 'UNCLAIMED';
    const CLAIMED = 'CLAIMED';
    const UNDER_REVIEW = 'UNDER_REVIEW';
    const COMPLETE = 'COMPLETE';
}
