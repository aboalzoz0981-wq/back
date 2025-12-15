<?php

namespace App;

use Illuminate\Http\UploadedFile;

trait UploadFileTrait
{
   public function upload(UploadedFile $file,$folder,$disk){
    return $file->store($folder,$disk);
   }
}
