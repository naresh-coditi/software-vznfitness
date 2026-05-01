<?php

namespace App\Services;

use App\Enum\UserType;
use App\Models\Media;
use App\Models\MembershipPlan;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserMembershipDetail;
use App\Models\UserProfile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserService
{
    public function createUser(Request $request)
    {
        try {
            $user = DB::transaction(function () use ($request) {
                $user = User::create([
                    'email' => $request->email ?? null,
                    'password' => $request->password ? Hash::make($request->password) : null,
                    'branch_id' => $request->branch ?? null,
                    'phone' => $request->phone ?  $request->phone : null,
                    'role_id' => User::User
                ]);

                $user->update([
                    'member_id' => $user->id + 1000
                ]);
                // Add role in pivot table using relation
                UserProfile::create([
                    'first_name' => $request->first_name ? $request->first_name : null,
                    'last_name' => $request->last_name ? $request->last_name : null,
                    'address' => $request->address ? $request->address : null,
                    'gender' => $request->gender ? $request->gender : null,
                    'user_type' => UserType::MEMBER['value'],
                    'user_id' => $user->id ? $user->id : null,
                    'created_by' => Auth::id()  ? Auth::id() : $user->id,
                    'updated_by' => Auth::id() ? Auth::id() : $user->id,
                ]);

                UserMembershipDetail::create([
                    'user_id' => $user->id,
                    'name' => $request->membership_duration,
                    'amount' => $request->amount,
                    'remaining_amount' => $request->remaining_amount,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'notes' => $request->note
                ]);

                Transaction::create([
                    'user_id' => $user->id,
                    'transaction_date' => today(),
                    'method_type' => $request->method_type,
                    'created_by' => Auth::id(),
                    'amount' => $request->amount
                ]);

                if ($request->file('image')) {
                    $media = Media::make([
                        'name' => $request->file('image')->getClientOriginalName(),
                        'path' => storeImage($request->file('image')),
                        'type' => 'png',
                        'size' => $request->file('image') ? $request->file('image')->getSize() : NULL
                    ]);

                    $media->imageable()->associate($user);
                    $media->save();
                }
                return $user;
            });

            return $user;
        } catch (Exception $e) {
            Log::error($e);
            return false;
        }
    }

    public function createStaff(Request $request)
    {
        try {
            $user = DB::transaction(function () use ($request) {
                $user = User::create([
                    'email' => $request->email ?? null,
                    'password' => $request->password ? Hash::make($request->password) : null,
                    'branch_id' => $request->branch ?? null,
                    'phone' => $request->phone ?  $request->phone : null,
                    'role_id' => User::Staff
                ]);

                $user->update([
                    'member_id' => $user->id + 1000
                ]);

                // Add role in pivot table using relation
                UserProfile::create([
                    'first_name' => $request->first_name ? $request->first_name : null,
                    'last_name' => $request->last_name ? $request->last_name : null,
                    'address' => $request->address ? $request->address : null,
                    'gender' => $request->gender ? $request->gender : null,
                    'user_type' => null,
                    'user_id' => $user->id ? $user->id : null,
                    'created_by' => Auth::id()  ? Auth::id() : $user->id,
                    'updated_by' => Auth::id() ? Auth::id() : $user->id,
                ]);

                if ($request->file('image')) {
                    $media = Media::make([
                        'name' => $request->file('image')->getClientOriginalName(),
                        'path' => storeImage($request->file('image')),
                        'type' => 'png',
                        'size' => $request->file('image') ? $request->file('image')->getSize() : NULL
                    ]);

                    $media->imageable()->associate($user);
                    $media->save();
                }
                return $user;
            });

            return $user;
        } catch (Exception $e) {
            Log::error($e);
            return false;
        }
    }

    public function updateUser(User $user, Request $request)
    {
        try {
            $user = DB::transaction(function () use ($user, $request) {
                $user->update([
                    'phone' => $request->phone,
                    // 'email' => $request->email,
                    'member_id' => $user->id + 1000,
                    'branch_id' => $request->branch,
                ]);

                $user->UserProfile->updateOrCreate(['id' => $user->UserProfile->id ?? null], [
                    'user_id' => $user->id,
                    'user_type' => UserType::MEMBER['value'],
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'gender' => $request->gender,
                    'address' => $request->address,
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id(),
                ]);

                if ($request->file('image') && $user->image->path) {
                    $uploadedImage = $request->file('image');
                    $uploadedImageSize = $uploadedImage->getSize();
                    $user->image->update([
                        'path' => storeImage($uploadedImage, $user->image->path),
                        'type' => 'png',
                        'size' => $uploadedImageSize
                    ]);
                } elseif ($request->file('image')) {
                    $uploadedImage = $request->file('image');
                    $uploadedImageSize = $uploadedImage->getSize();
                    $media = Media::make([
                        'name' => $uploadedImage->getClientOriginalName(),
                        'path' => storeImage($uploadedImage),
                        'type' => 'png',
                        'size' => $uploadedImageSize
                    ]);

                    $media->imageable()->associate($user);
                    $media->save();
                }

                if ($request->membership_duration) {
                    $user->latestPlan->update([
                        'name' => $request->membership_duration,
                        'amount' => $request->amount,
                        'remaining_amount' => $request->remaining_amount,
                        'start_date' => $request->start_date,
                        'end_date' => $request->end_date,
                        'notes' => $request->note
                    ]);
                }

                return $user;
            });

            return $user;
        } catch (Exception $e) {
            Log::error($e);
            return false;
        }
    }
}
