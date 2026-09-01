<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Central audit trail writer used across the application for regulatory-grade
 * traceability of sensitive actions (auth events, admin edits, etc.).
 */
class AuditService
{
    public function record(
        string $event,
        Model|string|null $auditable = null,
        array $changes = [],
        ?User $user = null,
    ): AuditLog {
        $user ??= auth()->user();

        return AuditLog::create([
            'user_id' => $user?->getKey(),
            'event' => $event,
            'auditable_type' => is_object($auditable) ? get_class($auditable) : $auditable,
            'auditable_id' => is_object($auditable) ? (string) $auditable->getKey() : null,
            'changes' => $changes ?: null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
