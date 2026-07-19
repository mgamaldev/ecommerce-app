<?php

namespace Tests\Support\Traits;

trait AdminCrudTestSuite
{
    abstract protected function endpoint(): string;

    abstract protected function modelFactory();

    abstract protected function storeValidData(): array;

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

    public function test_store(): void
    {
        $data = $this->storeValidData();
        $this->assertAdminSuccess('Post', $this->endpoint(), $data,
            function () use ($data) {
                $table = app($this->modelFactory())->getTable();
                $this->assertDatabaseHas($table, $data);
            }
        );
    }

    public function test_update(): void
    {
        $model = $this->modelFactory()::factory()->create();
        $data = $this->updateValidData();
        $this->assertAdminSuccess('PUT', "{$this->endpoint()}/{$model->id}", $data);
    }

    public function test_delete(): void
    {
        $model = $this->modelFactory()::factory()->create();
        $this->assertAdminSuccess('Delete', "{$this->endpoint()}/{$model->id}", [],
            function () use ($model) {
                $table = app($this->modelFactory())->getTable();
                $this->assertSoftDeleted($table, ['id' => $model->id]);
            }
        );
    }

    public function test_restore(): void
    {
        $model = $this->modelFactory()::factory()->trashed()->create();
        // dump($model->wasChanged('deleted_at'));
        $this->assertAdminSuccess('PATCH', "{$this->endpoint()}/{$model->id}/restore", [],
            function () use ($model) {
                $table = app($this->modelFactory())->getTable();
                $this->assertDatabaseHas($table, ['id' => $model->id, 'deleted_at' => null]);

            }
        );
    }

    public function test_force_delete(): void
    {
        $model = $this->modelFactory()::factory()->trashed()->create();
        $this->assertAdminSuccess('Delete', "{$this->endpoint()}/{$model->id}/force", [],
            function () use ($model) {
                $table = app($this->modelFactory())->getTable();
                $this->assertDatabaseMissing($table, ['id' => $model->id]);
            }
        );
    }
}
