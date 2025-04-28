<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

trait WithFilters
{

    public function scopeFilter(Builder $query)
    {
        if (!property_exists($this, 'filterableFields') || empty($this->filterableFields)) {
            return $query;
        }

        foreach ($this->filterableFields as $field => $config) {
            $query->when(request()->filled($field), function ($q) use ($field, $config) {
                $value = trim(request()->input($field));

                if (isset($config['allowed']) && !in_array($value, $config['allowed'], true)) {
                    return;
                }

                $operator = $config['operator'] ?? '=';
                $method = $config['method'] ?? 'where';
                $realField = $config['field'] ?? $field;

                if ($operator === 'like') {
                    $value = '%' . strtolower($value) . '%';
                    if ($method === 'where') {
                        $q->where($realField, 'like', $value);
                    } elseif ($method === 'whereTranslationLike') {
                        $q->whereTranslationLike($realField, $value);
                    }
                } elseif ($method === 'custom' && isset($config['fields'])) {
                    $q->where(function ($subQuery) use ($value, $config) {
                        foreach ($config['fields'] as $subField) {
                            $subQuery->orWhere($subField, 'like', '%' . $value . '%');
                        }
                    });
                } else {
                    $q->$method($realField, $operator, $value);
                }
            });
        }


        return $query;
    }
}
