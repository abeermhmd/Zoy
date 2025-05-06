<?php

namespace App\Services;

use App\Actions\Colors\{CreateColorAction, UpdateColorAction, GetColorAction ,GetColorsAction};
use App\Contracts\ColorContract;
use App\DataTransferObjects\Colors\{ColorDataTransfer,ColorFilterDataTransfer};
use App\Models\Color;

class ColorService implements ColorContract {

   public function getColors(?ColorFilterDataTransfer $filters = null)
   {
       return GetColorsAction::execute($filters);
   }

    public function getColor(string $id)
    {
      return  GetColorAction::execute($id);
    }
    public function createColor(ColorDataTransfer $data)
    {
        CreateColorAction::execute($data);
    }
    public function updateColor(Color $color, ColorDataTransfer $data)
    {
       UpdateColorAction::execute($color, $data);
    }
}
