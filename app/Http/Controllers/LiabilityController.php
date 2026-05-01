<?php

namespace App\Http\Controllers;

use App\Enum\LiabilityRange;
use App\Enum\UserType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class LiabilityController extends Controller
{
    public function index()
{
    $users = User::filterByLiabilityRange();
    $currentPage = request()->get('page', 1);
    $perPage = 50;
    $paginated = new LengthAwarePaginator(
        $users->forPage($currentPage, $perPage),
        $users->count(),
        $perPage,
        $currentPage,
        ['path' => request()->url(), 'query' => request()->query()]
    );

    return view('admin.liability.index', [
        'users' => $paginated,
        'request' => request(),
        'liabilityRange'=>LiabilityRange::getLiabilityRange(),
    ]);
}
}
