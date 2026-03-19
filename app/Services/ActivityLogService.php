<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ActivityLogService
{
    public function log(
        ?User $user,
        string $event,
        string $description,
        ?Model $subject = null,
        array $properties = [],
        ?string $ipAddress = null,
    ): ActivityLog {
        return ActivityLog::query()->create([
            'user_id' => $user?->id,
            'event' => $event,
            'description' => $description,
            'subject_type' => $subject?->getMorphClass(),
            'subject_id' => $subject?->getKey(),
            'properties' => $properties,
            'ip_address' => $ipAddress,
        ]);
    }
}
