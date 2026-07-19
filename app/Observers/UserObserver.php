<?php

namespace App\Observers;

use App\Traits\LogsAudit;

class UserObserver
{
    use LogsAudit;

    protected function actorId(): ?int
    {
        return app('actor_id');
    }

    public function updated($model)
    {
        $this->LogActivity($model, 'active_status_updated', $model->getOriginal(), $model->toArray(), $actorId = $this->actorId());
    }
}
