<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ExerciseImageController extends Controller
{
    public function index(Exercise $exercise)
    {
        return response()->json($exercise->images()->get());
    }

    public function create(Exercise $exercise)
    {
        return view('admin.workout.exercise.upload', [
            'exercise' => $exercise->load('category'),
            'images' => $exercise->images()->get()
        ]);
    }

    public function store(Exercise $exercise, Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpeg,jpg,png',
        ]);

        if ($request->file('file')) {
            // $file = $request->file('file');
            $filename = time() . '-' . $request->file('file')->getClientOriginalName();
            $filePath =  storeExerciseImage($request->file('file'));

            // Store file information in the database
            if ($filePath) {
                $media = Media::make([
                    'name' => $request->file('file')->getClientOriginalName(),
                    'path' => $filePath,
                    'type' => 'png',
                    'size' => $request->file('file') ? $request->file('file')->getSize() : NULL
                ]);

                $media->imageable()->associate($exercise);
                $media->save();
                return response()->json(['success' => $filename, 'path' => $filePath, 'id' => $media->id, 'size' => $media->size, 'name' => $filename]);
            }

            return response()->json(['error' => 'File not uploaded'], 500);
        }
        return response()->json(['error' => 'File not uploaded'], 500);
    }

    public function delete(Exercise $exercise, Request $request)
    {
        try {
            $image = $exercise->images()->where('id', $request->id)->first();
            if ($image && file_exists(storage_path('app/public/' . $image->path))) {
                unlink(storage_path('app/public/' . $image->path));
            }
            $image->delete();
            return response()->json(['success' => 'Image deleted'], 200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json(['error' => 'File not deleted'], 500);
        }
    }
}
