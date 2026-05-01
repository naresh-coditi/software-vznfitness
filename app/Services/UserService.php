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
            // #region agent log
            file_put_contents(
                base_path('debug-fc005a.log'),
                json_encode([
                    'sessionId' => 'fc005a',
                    'runId' => 'members-edit-2',
                    'hypothesisId' => 'H1',
                    'location' => 'app/Services/UserService.php:updateUser:entry',
                    'message' => 'updateUser called',
                    'data' => [
                        'user_id' => $user->id,
                        'has_image_file' => $request->hasFile('image'),
                        'existing_image_path' => $user->image->path ?? null,
                        'has_profile_relation' => (bool) $user->UserProfile,
                        'has_latest_plan' => (bool) $user->latestPlan,
                    ],
                    'timestamp' => round(microtime(true) * 1000),
                ], JSON_UNESCAPED_SLASHES) . PHP_EOL,
                FILE_APPEND
            );
            // #endregion
            $user = DB::transaction(function () use ($user, $request) {
                $user->update([
                    'phone' => $request->phone,
                    // 'email' => $request->email,
                    'member_id' => $user->id + 1000,
                    'branch_id' => $request->branch,
                ]);
                // #region agent log
                file_put_contents(
                    base_path('debug-fc005a.log'),
                    json_encode([
                        'sessionId' => 'fc005a',
                        'runId' => 'members-edit-2',
                        'hypothesisId' => 'H1',
                        'location' => 'app/Services/UserService.php:updateUser:afterUserUpdate',
                        'message' => 'User base record updated',
                        'data' => [
                            'user_id' => $user->id,
                            'phone' => $request->phone,
                            'branch' => $request->branch,
                        ],
                        'timestamp' => round(microtime(true) * 1000),
                    ], JSON_UNESCAPED_SLASHES) . PHP_EOL,
                    FILE_APPEND
                );
                // #endregion

                // #region agent log
                file_put_contents(
                    base_path('debug-fc005a.log'),
                    json_encode([
                        'sessionId' => 'fc005a',
                        'runId' => 'members-edit-2',
                        'hypothesisId' => 'H1',
                        'location' => 'app/Services/UserService.php:updateUser:beforeProfileUpdate',
                        'message' => 'About to update profile',
                        'data' => [
                            'profile_id' => $user->UserProfile->id ?? null,
                        ],
                        'timestamp' => round(microtime(true) * 1000),
                    ], JSON_UNESCAPED_SLASHES) . PHP_EOL,
                    FILE_APPEND
                );
                // #endregion
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
                // #region agent log
                file_put_contents(
                    base_path('debug-fc005a.log'),
                    json_encode([
                        'sessionId' => 'fc005a',
                        'runId' => 'members-edit-2',
                        'hypothesisId' => 'H1',
                        'location' => 'app/Services/UserService.php:updateUser:afterProfileUpdate',
                        'message' => 'Profile updated',
                        'data' => [
                            'profile_id' => $user->UserProfile->id ?? null,
                        ],
                        'timestamp' => round(microtime(true) * 1000),
                    ], JSON_UNESCAPED_SLASHES) . PHP_EOL,
                    FILE_APPEND
                );
                // #endregion

                if ($request->file('image') && $user->image->path) {
                    $uploadedImage = $request->file('image');
                    $uploadedImageSize = $uploadedImage->getSize();
                    // #region agent log
                    file_put_contents(
                        base_path('debug-fc005a.log'),
                        json_encode([
                            'sessionId' => 'fc005a',
                            'runId' => 'members-edit-2',
                            'hypothesisId' => 'H2',
                            'location' => 'app/Services/UserService.php:updateUser:imageUpdateBranch',
                            'message' => 'Updating existing image record',
                            'data' => [
                                'old_path' => $user->image->path,
                                'new_name' => $request->file('image')->getClientOriginalName(),
                            ],
                            'timestamp' => round(microtime(true) * 1000),
                        ], JSON_UNESCAPED_SLASHES) . PHP_EOL,
                        FILE_APPEND
                    );
                    // #endregion
                    $user->image->update([
                        'path' => storeImage($uploadedImage, $user->image->path),
                        'type' => 'png',
                        'size' => $uploadedImageSize
                    ]);
                } elseif ($request->file('image')) {
                    $uploadedImage = $request->file('image');
                    $uploadedImageSize = $uploadedImage->getSize();
                    // #region agent log
                    file_put_contents(
                        base_path('debug-fc005a.log'),
                        json_encode([
                            'sessionId' => 'fc005a',
                            'runId' => 'members-edit-2',
                            'hypothesisId' => 'H2',
                            'location' => 'app/Services/UserService.php:updateUser:imageCreateBranch',
                            'message' => 'Creating new image record',
                            'data' => [
                                'new_name' => $request->file('image')->getClientOriginalName(),
                            ],
                            'timestamp' => round(microtime(true) * 1000),
                        ], JSON_UNESCAPED_SLASHES) . PHP_EOL,
                        FILE_APPEND
                    );
                    // #endregion
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
                    // #region agent log
                    file_put_contents(
                        base_path('debug-fc005a.log'),
                        json_encode([
                            'sessionId' => 'fc005a',
                            'runId' => 'members-edit-2',
                            'hypothesisId' => 'H3',
                            'location' => 'app/Services/UserService.php:updateUser:beforeLatestPlanUpdate',
                            'message' => 'About to update latest plan',
                            'data' => [
                                'latest_plan_id' => $user->latestPlan->id ?? null,
                                'duration' => $request->membership_duration,
                            ],
                            'timestamp' => round(microtime(true) * 1000),
                        ], JSON_UNESCAPED_SLASHES) . PHP_EOL,
                        FILE_APPEND
                    );
                    // #endregion
                    $user->latestPlan->update([
                        'name' => $request->membership_duration,
                        'amount' => $request->amount,
                        'remaining_amount' => $request->remaining_amount,
                        'start_date' => $request->start_date,
                        'end_date' => $request->end_date,
                        'notes' => $request->note
                    ]);
                    // #region agent log
                    file_put_contents(
                        base_path('debug-fc005a.log'),
                        json_encode([
                            'sessionId' => 'fc005a',
                            'runId' => 'members-edit-2',
                            'hypothesisId' => 'H3',
                            'location' => 'app/Services/UserService.php:updateUser:afterLatestPlanUpdate',
                            'message' => 'Latest plan updated',
                            'data' => [
                                'latest_plan_id' => $user->latestPlan->id ?? null,
                            ],
                            'timestamp' => round(microtime(true) * 1000),
                        ], JSON_UNESCAPED_SLASHES) . PHP_EOL,
                        FILE_APPEND
                    );
                    // #endregion
                }

                return $user;
            });

            return $user;
        } catch (Exception $e) {
            // #region agent log
            file_put_contents(
                base_path('debug-fc005a.log'),
                json_encode([
                    'sessionId' => 'fc005a',
                    'runId' => 'members-edit-2',
                    'hypothesisId' => 'H4',
                    'location' => 'app/Services/UserService.php:updateUser:exception',
                    'message' => 'updateUser threw exception',
                    'data' => [
                        'error' => $e->getMessage(),
                        'line' => $e->getLine(),
                        'file' => $e->getFile(),
                    ],
                    'timestamp' => round(microtime(true) * 1000),
                ], JSON_UNESCAPED_SLASHES) . PHP_EOL,
                FILE_APPEND
            );
            // #endregion
            Log::error($e);
            return false;
        }
    }
}
