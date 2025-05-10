<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait FromRequest
{
    public static function fromRequest(Request|array $input = []): static
    {
        $ref = new \ReflectionClass(static::class);

        // تحديد إذا كان الإدخال Request أو array
        $data = $input instanceof Request
            ? static::extractRequestData($input)
            : $input;

        // جمع البارامترات اللي موجودة في الإدخال
        $params = collect($ref->getConstructor()?->getParameters())
            ->filter(fn($param) => array_key_exists($param->getName(), $data))
            ->mapWithKeys(fn($param) => [$param->getName() => $data[$param->getName()]]);

        // إنشاء instance جديد من الكلاس
        $instance = new static(...$params->all());

        // تعبئة الـ properties العامة إذا كانت موجودة في الإدخال
        foreach ($ref->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            $name = $property->getName();
            if (!$params->has($name) && array_key_exists($name, $data)) {
                $instance->$name = $data[$name];
            }
        }

        return $instance;
    }

    /**
     * استخراج البيانات من الـ Request
     */
    protected static function extractRequestData(Request $request): array
    {
        $data = [];
        $ref = new \ReflectionClass(static::class);

        foreach ($ref->getConstructor()?->getParameters() as $param) {
            $name = $param->getName();
            if ($request->hasFile($name)) {
                $data[$name] = $request->file($name);
            } elseif ($request->has($name)) {
                $data[$name] = $request->input($name);
            }
        }

        // إضافة أي بيانات إضافية من الـ Request للـ properties العامة
        foreach ($ref->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            $name = $property->getName();
            if (!array_key_exists($name, $data) && $request->has($name)) {
                $data[$name] = $request->input($name);
            }
        }

        return $data;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
