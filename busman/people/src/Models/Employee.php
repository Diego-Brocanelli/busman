<?php

namespace Busman\People\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Busman\Jobs\Models\Task;
use Busman\Utils\Traits\HasScope;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Employee extends Model implements AuditableContract
{
    use SoftDeletes, Searchable, HasScope, AuditableTrait;

    protected $appends = [
        'is_busy'
    ];

    public function toSearchableArray()
    {
        $this->load('user');

        $array = $this->toArray();

        $array['meta'] = metatostring($array['meta']);

        $array['_default'] = $array['user']['name'];

        return $array;
    }

    protected $dates = [
        'deleted_at'
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    protected $fillable = [
        'user_id', 'department', 'meta', 'team_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'employee_tasks')->withPivot('worker', 'active');
    }

    /* ----------------------------------------------------------------------------------------------------
     * Virtual attributes
     * ---------------------------------------------------------------------------------------------------*/
    public function getIsBusyAttribute()
    {
        return $this->tasks()->where('active', true)->where('worker', true)->get()->count() > 0;
    }
}
