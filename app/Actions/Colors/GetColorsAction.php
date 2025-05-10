<?php

namespace App\Actions\Colors;

use App\DataTransferObjects\Colors\ColorFilterDataTransfer;
use App\Models\Color;

class GetColorsAction
{
    public static function execute(?ColorFilterDataTransfer $filters)
    {
        $query = Color::filter($filters)
        ->orderBy($filters->orderBy ?? 'id', $filters->direction ?? 'desc');
        if ($filters->isPaginate) {
            $perPage = get_setting('dashboard_paginate');
            return $query->paginate($perPage)->appends(request()->query());
        }
        return $query->get();
  }
}
