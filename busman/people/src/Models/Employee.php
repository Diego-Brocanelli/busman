<?php

namespace Busman\People\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Busman\Utils\Traits\HasScope;

class Employee extends Model
{
    use SoftDeletes, Searchable, HasScope;

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
}
