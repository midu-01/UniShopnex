<?php

namespace App\Support;

use App\Models\User;

class DashboardRedirector
{
    public function routeFor(?User $user): string
    {
        if (! $user) {
            return route('home');
        }

        if ($user->hasRole('admin')) {
            return route('admin.dashboard');
        }

        if ($user->hasRole('vendor')) {
            return route('vendor.dashboard');
        }

        return route('customer.dashboard');
    }
}
