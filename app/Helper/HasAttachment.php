<?php

namespace App\Helper;

use App\Models\Image;
use Illuminate\Support\Facades\File;

trait HasAttachment
{
    public function imageable()
    {
        return $this->morphTo();
    }

    public function attachment()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function hasAttachment()
    {
        return (bool) $this->attachment()->count();
    }

    private function saveAttachment($request)
    {
        if (!$request->attachment) {
            return $this;
        }

        $path = storage_path('app/public/');
        !is_dir($path) && mkdir($path, 0775, true);

        $file     = $request->file('attachment');
        $fileName = uniqid() . '_' . trim($file->getClientOriginalName());

        if ($this->hasAttachment()) {
            /*
            if (File::exists($path . $this->attachment->path)) {
                File::delete($path . $this->attachment->path);
            }
            */
            $file->move($path, $fileName);
            return $this->attachment()->update([
                'path'  => $fileName,
            ]);
        }

        $file->move($path, $fileName);
        return $this->attachment()->create([
            'path'  => $fileName,
        ]);
    }

    private function updateAttachment($request)
    {
      
        if (!$request->attachment_url) {
            return $this;
        }

        $path = storage_path('app/public/');
        !is_dir($path) && mkdir($path, 0775, true);
    
        $file     = $request->file('attachment_url');

        $fileName = uniqid() . '_' . trim($file->getClientOriginalName());
  
        if ($this->hasAttachment()) {
           /* if (File::exists($path . $this->attachment_url->path)) {
                File::delete($path . $this->attachment_url->path);
            }*/
            //dd($path);
            $file->move($path, $fileName);
            //dd($file->move($path, $fileName));
            return $this->attachment()->update([
                'path'  => $fileName,
            ]);
        }

        $file->move($path, $fileName);
        return $this->attachment()->create([
            'path'  => $fileName,
        ]);
    }
}
