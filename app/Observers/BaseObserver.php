<?php

namespace App\Observers;

use App\Traits\LogsAudit;

class BaseObserver
{
    use LogsAudit;

    protected function actorId(): ?int
    {
        return app('actor_id');
    }

    public function created($model)
    {
        $this->logActivity($model, 'created', null, $model->toArray(), $actorId = $this->actorId());
    }

    public function updated($model)
    {
        $this->logActivity($model, 'updated', $model->getOriginal(), $model->toArray(), $actorId = $this->actorId());
    }

    public function deleted($model)
    {
        $this->logActivity($model, 'soft_deleted', $model->toArray(), null, $actorId = $this->actorId());
    }

    public function restored($model)
    {
        $this->logActivity($model, 'restored', null, $model->toArray(), $actorId = $this->actorId());
    }

    public function forceDeleted($model)
    {
        $this->logActivity($model, 'force_deleted', $model->toArray(), null, $actorId = $this->actorId());
    }
}
