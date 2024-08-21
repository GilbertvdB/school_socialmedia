<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Image;
use App\Traits\UploadableFile;

class FileController extends Controller
{
    use UploadableFile;

    /**
     * Remove the specified document from storage.
     */
    public function destroyDocument($id)
    {   
        $document = Document::findOrFail($id);
        $this->removeFile(array($document));
        $document->delete();

        return response()->json(['message' => 'Document deleted successfully']);
    }

    /**
     * Remove the specified document from storage.
     */
    public function destroyImage($id)
    {
        $image = Image::findOrFail($id);
        $this->removeFile(array($image));
        $image->delete();

        return response()->json(['message' => 'Image deleted successfully']);
    }

}
