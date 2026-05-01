<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Media;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CheckInController extends Controller
{
    public function index()
    {
        return view('CheckInMember.index');
    }
    public function mark()
    {
        try {
            $user = User::where('member_id', request('id'))
                ->where('role_id', User::User)
                ->where('phone',  request('number'))
                ->first();
            if (!$user) {
                return back()->with('error', 'Member Not Found');
            }
            $attendanceExists = Attendance::where('member_id', $user->id)
                ->whereDate('created_at', today())
                ->where('timing', request('time'))
                ->exists();

            if ($attendanceExists) {
                return back()->with('warning', $user->userProfile->fullName .' Your Attendance Already Marked For Today`s '. request('time'));

            }
            // Mark attendance
            Attendance::create([
                'member_id' => $user->id,
                'phone' => request('number'),
                'timing' => request('time'),
            ]);
            if ($user->image->path == null) {
                flash($user->userProfile->fullName . ' Your Attendance Is Marked', 'success');
                return view('CheckInMember.mark', [
                    'user' => $user,
                ]);
            }
            return back()->with('success', $user->userProfile->fullName . ' Your Attendance Is Marked');
        } catch (\Throwable $th) {
            Log::info('Error while checkIn: ' . $th->getMessage());
            return back()->with('error', 'An error occurred while marking attendance.');
        }
    }


    public function store(Request $request, User  $user)
    {
        try {
            $request->validate([
                'profile_picture'=>'required',
            ]);
            if ($request->input('profile_picture')) {
                // Decode the base64 image 
                [$imageName, $decodedImage] = decodeImage($request->input('profile_picture'));

                $path = Storage::disk('public')->put('images/profile_images/' . $imageName, $decodedImage);

                if (!$path) {
                    return back()->with('error', 'Failed to upload the profile image.');
                }
                // Store the profile image in the Media model
                $media = Media::make([
                    'name' => $imageName,
                    'path' => 'images/profile_images/' . $imageName,
                    'type' => 'png',
                    'size' => strlen($decodedImage),
                ]);
                $media->imageable()->associate($user);
                $media->save();
            }
            session()->put('checkProfile', true);
            return back()->with('success', $user->userProfile->fullName . ' Your Profile Is Uploaded');
        } catch (\Throwable $th) {
            Log::info('Error while checkIn:' . $th->getMessage());
            return back()->with('error', 'An error occurred while marking attendance.');
        }
    }
}
