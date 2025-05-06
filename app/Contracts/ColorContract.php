<?php

namespace App\Contracts;

use App\Models\Color;
use App\DataTransferObjects\Colors\{ColorDataTransfer, ColorFilterDataTransfer};

interface ColorContract
{
    public function getColors(?ColorFilterDataTransfer $filters = null);
    public function getColor(string $id);
    public function createColor(ColorDataTransfer $data);
    public function updateColor(Color $color, ColorDataTransfer $data);
}
