<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class AuthorDashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $filter = $request->query('filter', '');

        $sources = Auth::user()
            ->sources()
            ->with('translationRequests')
            ->when($filter === 'complete', function(Builder $query) {
                return $query->complete();
            })
            ->when($filter === 'incomplete', function(Builder $query) {
                return $query->incomplete();
            })
            ->orderByRecency()
            ->get();

        return view('author-dashboard', [
            'filter' => $filter,
            'sources' => $sources,
        ]);
    }
}
