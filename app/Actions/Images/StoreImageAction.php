<?php

namespace App\Actions\Images;

use Illuminate\Http\UploadedFile;

class StoreImageAction
{
    public function execute(UploadedFile $image, $storingPath): bool|string
    {
        $fileName = $image->getClientOriginalName();
        return $image->storeAs($storingPath, $fileName, 'public');    }
}