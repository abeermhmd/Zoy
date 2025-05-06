<?php

namespace App\Contracts;

use App\Models\Size;
use App\DataTransferObjects\Sizes\{SizeDataTransfer, SizeFilterDataTransfer};

interface SizeContract
{
    public function getSizes(?SizeFilterDataTransfer $filters = null);
    public function getSize(string $id);
    public function createSize(SizeDataTransfer $data);
    public function updateSize(Size $Size, SizeDataTransfer $data);
}
