<?php

namespace Busman\People\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Busman\Utils\Traits\HasScope;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Invitation extends Model implements AuditableContract
{
    use AuditableTrait, HasScope;

    public $incrementing = false;

    public function isExpired()
    {
        return Carbon::now()->subWeek()->gte($this->created_at);
    }
}
