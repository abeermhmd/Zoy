<?php

namespace App\Http\Controllers\AdminCpanel;

use App\Http\Controllers\Controller;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
class UploadImageController extends Controller
{
    use ImageTrait;
    public function storeOnlyImage(Request $request)
    {
        if ( $request->hasFile('upload')) {
            $imageName = $this->storeImage($request->file('upload'), 'imagesfeeds');
            $imagePath = 'uploads/images/imagesfeeds/' . basename($imageName);

            return response()->json([
                'uploaded' => 1,
                'fileName' => basename($imageName),
                'url' => asset($imagePath),
            ]);
        }
        return response()->json(['uploaded' => 0, 'error' => ['message' => 'Error uploading file']]);
    }

}
