<?php

use Carbon\Carbon;
use Nette\Utils\Random;

function dateFormat($date, $format = 'd-M-Y')
{
    if ($date) {
        return Carbon::parse($date)->format($format);
    }

    return null;
}

// Profile Image Store
function storeImage($image, $oldImage = null)
{
    if ($image) {
        // Remove old profile image from public or storage directories
        if ($oldImage && $oldImage != 'images/profile_images/profile_image.png') {
            $oldPublicPath = public_path($oldImage);
            $oldStoragePath = storage_path('app/public/' . $oldImage);

            if (file_exists($oldPublicPath)) {
                @unlink($oldPublicPath);
            }

            if (file_exists($oldStoragePath)) {
                @unlink($oldStoragePath);
            }
        }

        $directory = public_path('images/profile_images');

        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        $imageExtension = $image->getClientOriginalExtension() ?: 'png';
        $imageName = md5_file($image->getRealPath()) . time();
        $image->move($directory, $imageName . '.' . $imageExtension);

        return 'images/profile_images/' . $imageName . '.' . $imageExtension;
    }
    return NULL;
}

function decodeImage($imageData)
{
    // Remove the base64 prefix and decode the image
    $image = str_replace('data:image/png;base64,', '', $imageData);
    $image = str_replace(' ', '+', $image);
    $decodedImage = base64_decode($image);
    // Generate a unique name for the image
    $imageName = 'profile_' . time() . '.png';
    return [$imageName, $decodedImage];
}


function storeExerciseImage($image)
{
    if ($image) {
        // Remove old profile image from stroge director
        $imageName = md5_file($image) . time();
        return $image->storeAs('images/exercise', $imageName . '.png', 'public');
    }
    return NULL;
}

function profileImage($path = NULL)
{
    $placeholder = 'data:image/svg+xml;charset=UTF-8,' . rawurlencode('<svg xmlns="http://www.w3.org/2000/svg" width="160" height="160" viewBox="0 0 160 160"><rect width="160" height="160" rx="18" fill="#f3f4f6"/><circle cx="80" cy="62" r="28" fill="#d1d5db"/><path d="M34 136c9-25 30-38 46-38s37 13 46 38" fill="#d1d5db"/></svg>');

    if (!$path) {
        return $placeholder;
    }

    $publicPath = public_path($path);
    if (file_exists($publicPath)) {
        return asset($path);
    }

    $storagePath = storage_path('app/public/' . $path);
    if (file_exists($storagePath)) {
        $directory = dirname($publicPath);

        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        @copy($storagePath, $publicPath);

        if (file_exists($publicPath)) {
            return asset($path);
        }

        return asset('storage/' . $path);
    }

    return $placeholder;
}

function tagElement($status, $color)
{
    return '<p class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-normal opacity-70">
    <span class="relative inline-grid items-center font-sans font-bold uppercase whitespace-nowrap select-none bg-' . $color . '-500/30 text-' . $color . '-600 py-1 px-2 text-xs rounded-md">
        ' . $status . '
    </span>
</p> ';
}

function addDays($date, $days)
{
    $date = Carbon::parse($date);
    return $date->addDays($days);
}

function addDaysFromFormat($date, $days, $format = 'd/M/Y')
{
    $date = Carbon::createFromFormat($format, $date);
    return $date->addDays($days);
}

function changeDateFromFormat($date, $format = 'd/M/Y')
{
    $date = Carbon::createFromFormat($format, $date);
    return $date;
}

function findDiffDays($start_date, $end_date)
{
    $start_date = Carbon::parse($start_date);
    $end_date = Carbon::parse($end_date);

    return $end_date->diffInDays($start_date);
}

function generatePassword()
{
    return Random::generate(6);
}

function parseLiabilityRange(string $label)
{
    // Remove currency symbols and spaces
    $clean = str_replace(['₹', ' '], '', $label);

    // Handle open-ended range like "2000+"
    if (str_ends_with($clean, '+')) {
        $min = (int) str_replace('+', '', $clean);
        return ['min' => $min, 'max' => INF];
    }

    // Split the range like "500-1000"
    [$min, $max] = explode('-', $clean);

    return [
        'min' => (int) $min,
        'max' => (int) $max,
    ];
}
