<?php

namespace Busman\People\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Busman\Utils\Traits\HasScope;

class Invitation extends Model
{
    use HasScope;

    public $incrementing = false;

    public function isExpired()
    {
        return Carbon::now()->subWeek()->gte($this->created_at);
    }
}
