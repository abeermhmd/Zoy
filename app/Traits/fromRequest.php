<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait FromRequest
{
    public static function fromRequest(Request $request): static
    {
        $ref = new \ReflectionClass(static::class);

        $params = collect($ref->getConstructor()?->getParameters())
            ->filter(fn($param) => $request->has($param->getName()) || $request->hasFile($param->getName()))
            ->mapWithKeys(function ($param) use ($request) {
                $name = $param->getName();

                if ($request->hasFile($name)) {
                    return [$name => $request->file($name)];
                }

                return [$name => $request->input($name)];
            });

        $instance = new static(...$params->all());

        // لو فيه properties ما وصلت للكونستركتر، نعبيها يدويًا إذا كانت موجودة بالـ request
        foreach ($ref->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            $name = $property->getName();

            if (!$params->has($name) && $request->has($name)) {
                $instance->$name = $request->input($name);
            }
        }

        return $instance;
    }


    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
