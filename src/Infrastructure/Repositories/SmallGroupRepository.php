<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Enums\DayOfWeekEnum;
use App\Domain\Enums\ScheduleFrequencyEnum;
use App\Domain\Helpers\DateTimeHelpers;
use App\Domain\SmallGroup\SmallGroupEntity;
use App\Domain\SmallGroup\SmallGroupRepositoryInterface;
use App\Domain\SmallGroup\SmallGroupDataModel;
use App\Domain\SmallGroup\SmallGroupQueryModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SmallGroupRepository implements SmallGroupRepositoryInterface
{
    public function get(string $id): SmallGroupEntity
    {
        return SmallGroupEntity::findOrFail($id);
    }

    public function create(SmallGroupDataModel $data): SmallGroupEntity
    {
        $entity = SmallGroupEntity::createFromData($data);
        $entity->save();
        return $entity;
    }

    public function update(?string $id, SmallGroupDataModel $data): SmallGroupEntity
    {
        $entity = SmallGroupEntity::findOrFail($id);
        $entity->updateFromData($data);
        $entity->save();
        return $entity;
    }

    public function delete(string $id): bool
    {
        $entity = SmallGroupEntity::findOrFail($id);
        return $entity->delete();
    }

    public function getList(SmallGroupQueryModel $queryModel, int $page, int $perPage): Collection
    {
        $query = SmallGroupEntity::query()
            ->leftJoin('life_stages', 'small_groups.life_stage_id', '=', 'life_stages.id')
            ->leftJoin('persons', 'small_groups.leader_person_id', '=', 'persons.id')
            ->select([
                'small_groups.*',
                'life_stages.name as life_stage_name',
                DB::raw("CONCAT(persons.first_name, ' ', persons.last_name) AS leader_name"),
            ]);
        if (!empty($queryModel->lifeStageIds)) {
            $query->whereIn('small_groups.life_stage_id', $queryModel->lifeStageIds);
        }
        if (!empty($queryModel->leaderPersonId)) {
            $query->where('small_groups.leader_person_id', $queryModel->leaderPersonId);
        }
        if (!empty($queryModel->scheduleDays)) {
            $dayValues = array_map(fn(DayOfWeekEnum $d) => $d->value, $queryModel->scheduleDays);
            $query->whereIn('small_groups.schedule_day_of_week', $dayValues);
        }
        $paginated = $query->paginate($perPage, ['*'], 'page', $page);
        $transformed = $paginated->map(function ($row) {
            $data = new SmallGroupDataModel(
                id: $row->id,
                description: $row->description,
                lifeStageId: $row->life_stage_id,
                leaderPersonId: $row->leader_person_id,
                scheduleDayOfWeek: $row->schedule_day_of_week,
                scheduleTimeOfDay: $row->schedule_time_of_day,
                scheduleFrequency: $row->schedule_frequency,
                category: $row->category,
            );
            $data->lifeStageName = $row->life_stage_name ?? null;
            $data->leaderPersonName = $row->leader_name ?? null;
            $data->setBaseProperties(
                DateTimeHelpers::toDateImmutable($row->created_at),
                DateTimeHelpers::toDateImmutable($row->updated_at),
                null,
                null
            );
            return $data;
        });
        return $transformed;
    }
}