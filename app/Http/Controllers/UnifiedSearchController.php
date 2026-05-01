<?php

namespace App\Http\Controllers;

use App\Enum\UserType;
use App\Models\LeadUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

use function Laravel\Prompts\select;

class UnifiedSearchController extends Controller
{
    public function search()
    {
        $perPage = 50; // Change this to your desired items per page
        $currentPage = request()->input('page', 1);
        $search = request()->input('search', '');
    
        $users = User::withTrashed()
            ->unifiedfilter(request())
            ->get();
            
        $leads = LeadUser::unifiedfilter(request())
            ->get();

        $allData = $leads->concat($users)->sortByDesc('created_at')->values();

        //we are merging data from leads and users so paginate() will not work so we using lengthAwarePaginator
        $paginated = new LengthAwarePaginator(
            $allData->forPage($currentPage, $perPage),
            $allData->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('admin.unifiedSearch.unifiedSearch', [
            'members' => $paginated,
            'request' => request(),
        ]);
    }
}
