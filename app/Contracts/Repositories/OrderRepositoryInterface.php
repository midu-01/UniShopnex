<?php

namespace App\Contracts\Repositories;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface OrderRepositoryInterface
{
    public function paginateForUser(User $user, int $perPage = 10): LengthAwarePaginator;

    public function paginateForVendor(User $vendor, int $perPage = 10): LengthAwarePaginator;
}
