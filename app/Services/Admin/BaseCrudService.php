<?php

namespace App\Services\Admin;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

abstract class BaseCrudService
{
    abstract protected function getModelClass(): string;

    protected function getModel(): Model
    {
        return app($this->getModelClass());
    }

    public function getAll($request = null, int $perPage = 10): LengthAwarePaginator
    {
        return $this->getModel()->filter($request)->paginate($perPage);
    }

    public function getDetails(int $id): Model
    {
        return $this->getModel()->findOrFail($id);
    }

    public function create(array $data): Model
    {
        return DB::transaction(function () use ($data) {
            return $this->getModel()->create($data);
        });
    }

    public function update(int $id, array $data): Model
    {
        return DB::transaction(function () use ($id, $data) {

            $record = $this->getDetails($id);

            $record->update($data);

            return $record->refresh();
        });
    }

    public function softDelete(int $id): Model
    {
        $record = $this->getDetails($id);

        $record->delete();

        return $record;
    }

    public function restore(int $id): Model
    {
        $record = $this->getModel()->withTrashed()->findOrFail($id);

        $record->restore();

        return $record;
    }

    public function forceDelete(int $id): Model
    {
        $record = $this->getModel()->withTrashed()->findOrFail($id);

        $record->forceDelete();

        return $record;
    }
}
