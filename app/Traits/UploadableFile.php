<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;
use App\Models\Document;

trait UploadableFile
{
    /**
     * Upload images and attach them to the post.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Post $post
     * @return void
     */
    public function uploadImages(Request $request, $post)
    {
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = date('Y_m_d_His') . '_' . str_replace(' ', '', $file->hashName());
                $file->storePubliclyAs('images/posts/', $filename, 'public');

                $image = new Image([
                    'post_id' => $post->id,
                    'url' => 'images/posts/' . $filename,
                ]);
                $image->save();
            }
        }
    }

    /**
     * Upload documents and attach them to the post.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Post $post
     * @return void
     */
    public function uploadDocuments(Request $request, $post)
    {
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $filename = date('Y_m_d_His') . '_' . str_replace(' ', '', $file->getClientOriginalName());
                $file->storePubliclyAs('documents/posts/', $filename, 'public');

                $document = new Document([
                    'post_id' => $post->id,
                    'url' => 'documents/posts/' . $filename,
                ]);
                $document->save();
            }
        }
    }

    /**
     * Remove a file from storage.
     *
     * @param string $filePath
     * @return void
     */
    public function removeFile($files)
    {   
        if($files)
        {
            foreach($files as $file)
            {   
                Storage::disk('public')->delete($file->url);
            }
        }
    }
}
