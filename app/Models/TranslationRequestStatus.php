<?php

namespace App\Models;

abstract class TranslationRequestStatus {
    const UNCLAIMED = 'UNCLAIMED';
    const CLAIMED = 'CLAIMED';
    const COMPLETE = 'COMPLETE';
}
