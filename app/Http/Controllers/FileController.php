<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Image;
use App\Traits\UploadableFile;
use Illuminate\Http\JsonResponse;

class FileController extends Controller
{
    use UploadableFile;

    /**
     * Remove the specified document from storage.
     */
    public function destroyDocument($id): JsonResponse
    {   
        $document = Document::findOrFail($id);
        $this->removeFile(array($document));
        $document->delete();

        return response()->json(['message' => 'Document deleted successfully']);
    }

    /**
     * Remove the specified document from storage.
     */
    public function destroyImage($id): JsonResponse
    {
        $image = Image::findOrFail($id);
        $this->removeFile(array($image));
        $image->delete();

        return response()->json(['message' => 'Image deleted successfully']);
    }

}
