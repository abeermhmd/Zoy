<?php

namespace App\DataTransferObjects\Colors;
use App\Traits\FromRequest;
use Illuminate\Http\UploadedFile;

class ColorDataTransfer
{
    use FromRequest;

    public function __construct(
        public readonly ?string $name_en = null,
        public readonly ?string $name_ar = null,
        public readonly ?string $hex_code = null,
    ) {}
}
