<?php

namespace App\Traits;

use Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

trait ImageTrait
{
    public function storeImage($image, $fileName, $oldImageName = null, $width = null, $height = null, $type = 1)
    {
        if (!$image) {
            return null;
        }

        if ($type == 1) {
            return is_array($image) ? $this->storeMultipleImages($image, $fileName, $oldImageName, $width, $height) : $this->storeSingleImage($image, $fileName, $oldImageName, $width, $height);
        } else {
            return $this->storeOtherFiles($image, $fileName, $oldImageName);
        }
    }

    private function storeSingleImage($image, $fileName, $oldImageName = null, $width = null, $height = null)
    {
        if (is_string($image) && str_starts_with($image, 'data:image')) {
        $image = $this->convertBase64ToFile($image, $fileName);
        }

        if (!$image || !file_exists($image->getPathname())) {
            throw new \Exception("The uploaded image file does not exist.");
        }

        $extension = $image->getClientOriginalExtension();
        $imageName = $this->generateFileName($extension);

        $this->ensureDirectoryExists($fileName);

        if ($width || $height) {
            Image::make($image)->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path("uploads/images/$fileName/$imageName"));
        } else {
            $image->move(public_path("uploads/images/$fileName"), $imageName);
        }

        $this->deleteOldImage($fileName, $oldImageName);

        return $imageName;
    }


    private function storeMultipleImages($images, $fileName, $oldImageName = null, $width = null, $height = null)
    {
        $imageNames = [];
        foreach ($images as $img) {
            if ($img) {
                $imageNames[] = $this->storeSingleImage($img, $fileName, $oldImageName, $width, $height);
            }
        }
        return $imageNames;
    }

    private function storeOtherFiles($file, $fileName, $oldFileName = null)
    {
        $extension = $file->getClientOriginalExtension();
        $generatedFileName = $this->generateFileName($extension);
        $this->ensureDirectoryExists($fileName);
        $file->move(public_path("uploads/images/$fileName"), $generatedFileName);
        $this->deleteOldImage($fileName, $oldFileName);
        return $generatedFileName;
    }

    private function convertBase64ToFile($base64String, $folderName)
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $matches)) {
            $extension = $matches[1];
        } else {
            $extension = 'png';
        }

        $base64String = preg_replace('/^data:image\/\w+;base64,/', '', $base64String);
        $base64String = str_replace(' ', '+', $base64String);
        $decodedData = base64_decode($base64String);

        $this->ensureDirectoryExists($folderName);
        $fileName = uniqid() . '.' . $extension;
        $filePath = public_path("uploads/images/{$folderName}/{$fileName}");
        file_put_contents($filePath, $decodedData);

        if (!file_exists($filePath)) {
            throw new \Exception("Failed to create image file: {$filePath}");
        }
        return new UploadedFile($filePath, $fileName, 'image/' . $extension, null, true);
    }

    private function generateFileName($extension)
    {
        return Str::random(15) . "_" . date('Ymd_His') . "." . $extension;
    }

    private function ensureDirectoryExists($fileName)
    {
        $filePath = public_path("uploads/images/$fileName");
        if (!File::exists($filePath)) {
            File::makeDirectory($filePath, 0755, true);
        }
    }

    private function deleteOldImage($fileName, $oldImageName)
    {
        if ($oldImageName) {
            $oldImageName = basename($oldImageName);
            $filePath = public_path("uploads/images/$fileName/$oldImageName");
            if (File::exists($filePath)) {
                unlink($filePath);
            }
        }
    }
}
