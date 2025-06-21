<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Enums\GenderEnum;
use App\Domain\Person\PersonEntity;
use App\Domain\Person\PersonDataModel;
use App\Domain\Person\PersonQueryModel;
use App\Domain\Person\PersonRepositoryInterface;
use Illuminate\Support\Collection;

class PersonRepository implements PersonRepositoryInterface
{
    public function isExists(string $personId): bool
    {
        return PersonEntity::whereKey($personId)->exists();
    }

    public function save(?string $id, PersonDataModel $data): PersonEntity
    {
        if (!is_null($id) || !blank($id)) {
            $entity = PersonEntity::findOrFail($id);
            $entity->updateFromData($data);
            $entity->save();
            return $entity;
        }
        $entity = PersonEntity::createFromData($data);
        $entity->save();
        return $entity;
    }

    public function delete(string $id): bool
    {
        $entity = PersonEntity::findOrFail($id);
        return $entity->delete();
    }

    public function getList(PersonQueryModel $queryModel, int $page, int $perPage): Collection
    {
        $query = PersonEntity::query();
        if (!empty($queryModel->firstName)) {
            $query->where('first_name', 'like', '%' . $queryModel->firstName . '%');
        }

        if (!empty($queryModel->lastName)) {
            $query->where('last_name', 'like', '%' . $queryModel->lastName . '%');
        }
        
        if (!empty($queryModel->gender)) {
            $query->where('gender', $queryModel->gender instanceof GenderEnum
                ? $queryModel->gender
                : GenderEnum::from($queryModel->gender));
        }

        if (!empty($queryModel->lifeStageId)) {
            $query->where('life_stage_id', (int) $queryModel->lifeStageId);
        }

        $includedColumns = [
            'first_name',
            'last_name',
            'life_stage_id',
            'gender',
            'birthdate',
        ];
        $paginated = $query->paginate($perPage, $includedColumns, 'page', $page);
        $transformed = $paginated->getCollection()->map(function (PersonEntity $entity) {
            return PersonDataModel::fromEntity($entity);
        });
        return $transformed;
    }
}