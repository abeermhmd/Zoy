<?php

namespace App\Actions\Admins;

use App\DataTransferObjects\Admins\AdminFilterDataTransfer;
use App\Models\Admin;

class GetAdminsAction
{
    public static function execute(?AdminFilterDataTransfer $filters)
    {
        $query = Admin::where('id', '>', 1)
            ->orderBy($filters->orderBy, $filters->direction)
            ->filter($filters);
        if ($filters->isPaginate) {
            $perPage = get_setting('dashboard_paginate');
            return $query->paginate($perPage)->appends(request()->query());
        }
        return $query->get();
  }
}
