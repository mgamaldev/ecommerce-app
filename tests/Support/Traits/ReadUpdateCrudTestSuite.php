<?php

namespace Tests\Support\Traits;

trait ReadUpdateCrudTestSuite
{
    abstract protected function endpoint(): string;

    abstract protected function modelFactory();

    abstract protected function updateValidData(): array;

    public function test_index(): void
    {
        $this->assertAdminSuccess('Get', $this->endpoint());
    }

    public function test_show(): void
    {
        $model = $this->modelFactory()::factory()->create();
        $this->assertAdminSuccess('Get', "{$this->endpoint()}/{$model->id}");
    }

    public function test_update(): void
    {
        $model = $this->modelFactory()::factory()->create();
        $data = $this->updateValidData();
        $this->assertAdminSuccess('PUT', "{$this->endpoint()}/{$model->id}", $data);
    }
}
