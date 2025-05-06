<?php

namespace App\Services;

use App\Actions\Sizes\{CreateSizeAction, UpdateSizeAction, GetSizeAction, GetSizesAction};
use App\Contracts\SizeContract;
use App\DataTransferObjects\Sizes\{SizeDataTransfer, SizeFilterDataTransfer};
use App\Models\Size;

class SizeService implements SizeContract
{

    public function getSizes(?SizeFilterDataTransfer $filters = null)
    {
        return GetSizesAction::execute($filters);
    }

    public function getSize(string $id)
    {
        return GetSizeAction::execute($id);
    }

    public function createSize(SizeDataTransfer $data)
    {
        CreateSizeAction::execute($data);
    }

    public function updateSize(Size $Size, SizeDataTransfer $data)
    {
        UpdateSizeAction::execute($Size, $data);
    }

}
