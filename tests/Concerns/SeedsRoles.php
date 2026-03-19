<?php

namespace Tests\Concerns;

use Spatie\Permission\Models\Role;

trait SeedsRoles
{
    protected function seedRoles(): void
    {
        foreach (['admin', 'vendor', 'customer'] as $role) {
            Role::findOrCreate($role, 'web');
        }
    }
}
