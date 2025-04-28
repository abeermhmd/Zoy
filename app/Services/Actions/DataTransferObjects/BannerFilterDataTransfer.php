<?php

namespace App\Services\Actions\DataTransferObjects;

class BannerFilterDataTransfer
{
    public string|array|null $id;
    public ?string $title;
    public ?string $status;
    public ?int $order;
    public ?bool $isPaginate;
    public ?string $perPage;

    public function __construct(array $data = [])
    {
        $this->id = isset($data['id']) ? (string) $data['id'] : null;
        $this->title = isset($data['title']) ? (string) $data['title'] : null;
        $this->status = isset($data['status']) ? (string) $data['status'] : null;
        $this->order = isset($data['order']) && is_numeric($data['order']) ? (int) $data['order'] : null;
        $this->isPaginate = isset($data['isPaginate']) ? (bool) $data['isPaginate'] : false;
        $this->perPage = isset($data['perPage']) ? (string) $data['perPage'] : '10';
    }

    public static function toArray(BannerFilterDataTransfer $dto): array
    {
        return [
            'id' => $dto->id,
            'title' => $dto->title,
            'status' => $dto->status,
            'order' => $dto->order,
            'isPaginate' => $dto->isPaginate,
            'perPage' => $dto->perPage,
        ];
    }
}
