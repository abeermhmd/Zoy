<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait fromRequest
{
    public static function fromRequest(Request $request): static
    {
        $ref = new \ReflectionClass(static::class);

        $params = collect($ref->getConstructor()?->getParameters())
            ->mapWithKeys(function ($param) use ($request) {
                $name = $param->getName();

                if ($request->hasFile($name)) {
                    return [$name => $request->file($name)];
                }

                return [$name => $request->input($name)];
            });

        return new static(...$params->all());
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
