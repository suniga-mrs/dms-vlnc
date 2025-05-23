<?php

namespace App\Domain\Shared;

abstract class BaseDataModel {
    readonly public ?string $createdById;
    readonly public ?string $createdBy;
    readonly public ?string $createdAt;
    readonly public ?string $updatedAt;
}