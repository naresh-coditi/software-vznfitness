<?php

namespace App\Http\Controllers;

use App\Enum\UserType;
use App\Models\Branch;
use App\Models\PersonalTrainer;
use App\Models\User;
use App\Models\UserProfile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class TrainerController extends Controller
{
    public function index()
    {
        return view('admin.trainers.index', [
            'trainers' => User::with('userProfile', 'createdBy')
                ->filter(request())
                ->where('role_id', User::Trainer)
                ->paginate(50),
            'request' => request(),
        ]);
    }
    public function create()
    {
        return view('admin.trainers.create', [
            'branches' => Branch::get(),
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|min:0',
            'email' => 'required|email',
            'branch' => 'required',
            'phone' => 'required|unique:users,phone|digits:10',
            'gender' => 'required|min:1',
            'experience' => 'required',

        ]);

        try {
            DB::transaction(function () use ($request) {
                $user = User::create([
                    'email' => $request->email ?? null,
                    'branch_id' => $request->branch ?? null,
                    'phone' => $request->phone ?  $request->phone : null,
                    'role_id' => User::Trainer
                ]);
                $user->update([
                    'member_id' => $user->id + 1000
                ]);
                // Add role in pivot table using relation
                UserProfile::create([
                    'first_name' => $request->first_name ? $request->first_name : null,
                    'last_name' => $request->last_name ? $request->last_name : null,
                    'gender' => $request->gender ? $request->gender : null,
                    'user_type' => UserType::MEMBER['value'],
                    'user_id' => $user->id ? $user->id : null,
                    'created_by' => Auth::id()  ? Auth::id() : $user->id,
                    'updated_by' => Auth::id() ? Auth::id() : $user->id,
                    'experience' => $request->experience,
                ]);
            });
            flash('Trainer Added Successfully', 'success');
            return to_route(auth()->user()->roleName . 'trainers.index');
        } catch (Exception $e) {
            Log::error($e);
            flash('Operation Failed', 'error');
            return back();
        }
    }
    public function view($trainer)
    {
        return view('admin.trainers.view', [
            'trainer' => User::with('userProfile')->find($trainer),
        ]);
    }
    public function edit($trainer)
    {
        return view('admin.trainers.edit', [
            'trainer' => User::with('userProfile')->find($trainer),
            'branches' => Branch::get(),
        ]);
    }
    public function update(Request $request, $trainer)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'branch' => 'required',
            'phone' => 'required:max:10',
            'experience' => 'required',
        ]);
        $user = User::find($trainer);
        try {
            $user->update([
                'email' => $request->email,
                'phone' => $request->phone,
                'branch_id' => $request->branch,
            ]);
            $user->userProfile->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'gender' => $request->gender,
                'experience' => $request->experience,
            ]);
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Failed to update Trainer: ' . $th->getMessage()]);
        }
        return back()->with('success', 'Trainer Updated Successfully');
    }
    public function delete(User $user)
    {
        try {
            $user->delete();
            $user->userProfile->delete();
            flash('Trainer deleted successfully', 'success');
            return back();
        } catch (\Throwable $th) {
            Log::info($th);
            flash('Unable to remove Trainer', 'error');
            return back();
        }
    }
    public function showTrainer()
    {
        $data = PersonalTrainer::where('member_id', request('id'))->first();
        $trainer = User::find($data->trainer_id);
        if($trainer){
             return view('admin.trainers.view',[
            'trainer'=>$trainer,
        ]);
        }else{
            return back()->with('info','This trainer does not have profile');
        }
       
    }
}
