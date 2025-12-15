<?php 
use Illuminate\Support\Str;
 
 if (!function_exists('Capitalize')) {
     function Capitalize($text){
     return Str::upper($text);
    }
}