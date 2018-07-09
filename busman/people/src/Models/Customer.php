<?php

namespace Busman\People\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Busman\Utils\Traits\HasScope;

class Customer extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait, Searchable, HasScope;

    public function toSearchableArray()
    {
        $this->load('user');

        $array = $this->toArray();

        $array['meta'] = metatostring($array['meta']);

        $array['_default'] = $array['user']['name'];

        return $array;
    }

    protected $dates = ['deleted_at'];

    protected $casts = [
        'meta' => 'array',
    ];

    protected $table = 'customers';

    protected $fillable = ['user_id', 'business_name', 'meta', 'team_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
