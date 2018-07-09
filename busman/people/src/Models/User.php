<?php

namespace Busman\People\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Busman\Common\Models\Address;
use Busman\Common\Models\Email;
use Busman\Common\Models\Phone;
use Busman\Common\Models\Preference;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Busman\Acl\Traits\HasPermissions;
use Busman\People\Traits\HasTeams;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class User extends Authenticatable implements HasMedia, AuditableContract
{
    use HasTeams, HasApiTokens, HasMediaTrait, SoftDeletes, Notifiable, HasPermissions, AuditableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'image',
        'status',
        'password',
        //'current_team_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'authy_id',
        'country_code',
        'phone',
        'card_brand',
        'card_last_four',
        'card_country',
        'billing_address',
        'billing_address_line_2',
        'billing_city',
        'billing_zip',
        'billing_country',
        'extra_billing_information',
        'photo_url',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'trial_ends_at' => 'datetime',
        'uses_two_factor_auth' => 'boolean',
    ];

    public function phones()
    {
        return $this->belongsToMany(Phone::class, 'user_phones');
    }

    public function emails()
    {
        return $this->belongsToMany(Email::class, 'user_emails');
    }

    public function addresses()
    {
        return $this->belongsToMany(Address::class, 'user_addresses');
    }

    public function preferences()
    {
        return $this->hasOne(Preference::class);
    }

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }


}
