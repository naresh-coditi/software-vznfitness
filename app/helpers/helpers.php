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
        // Remove old profile image from stroge directory
        if ($oldImage && $oldImage != 'images/profile_images/profile_image.png' && file_exists(storage_path('app/public/' . $oldImage))) {
            unlink(storage_path('app/public/' . $oldImage));
        }

        $imageName = md5_file($image) . time();
        return $image->storeAs('images/profile_images', $imageName . '.png', 'public');
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
    return $path ? asset('storage/' . $path) : asset('storage/images/profile_images/profile_image.png');
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
