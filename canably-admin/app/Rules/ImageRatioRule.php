
<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ImageRatio implements Rule
{
    protected $ratio;

    public function __construct($ratio)
    {
        $this->ratio = $ratio;
    }

    public function passes($attribute, $value)
    {
        $image = Image::make($value);
        $width = $image->width();
        $height = $image->height();

        $expectedRatio = eval("return {$this->ratio};");

        return abs($width / $height - $expectedRatio) < 0.01;
    }

    public function message()
    {
        return 'The :attribute ratio must be '.$this->ratio;
    }
}
