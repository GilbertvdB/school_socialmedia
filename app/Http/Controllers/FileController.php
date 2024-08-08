<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{

    /**
     * Remove the specified document from storage.
     */
    public function destroyDocument($id)
    {   
        $document = Document::findOrFail($id);
        Storage::disk('public')->delete($document->url);
        $document->delete();

        return response()->json(['message' => 'Document deleted successfully']);
    }

    /**
     * Remove the specified document from storage.
     */
    public function destroyImage($id)
    {
        $image = Image::findOrFail($id);
        Storage::disk('public')->delete($image->url);
        $image->delete();

        return response()->json(['message' => 'Image deleted successfully']);
    }

}
