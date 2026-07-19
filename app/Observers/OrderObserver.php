<?php

namespace App\Observers;

use App\Traits\LogsAudit;

class OrderObserver
{
    use LogsAudit;

    protected function actorId(): ?int
    {
        return app('actor_id');
    }

    public function updated($model)
    {
        $this->LogActivity($model, 'payment_status_updated', $model->getOriginal(), $model->toArray(), $actorId = $this->actorId());
    }
}
