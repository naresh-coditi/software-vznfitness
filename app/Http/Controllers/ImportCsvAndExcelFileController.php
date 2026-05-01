<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ImportCsvAndExcelFileController extends Controller
{
    public function store(Request $request)
    {
        try {
            Excel::import(new UsersImport, $request->file);

            flash('User Imported Successfully', 'success');
            return redirect()->route(Auth::user()->roleName . 'user.index');
        } catch (Exception $e) {
            Log::error($e);
            flash('Unable to import user due to :' . $e->getMessage(), 'error');
            return back();
        }
    }
}
