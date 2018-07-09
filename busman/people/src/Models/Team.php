<?php

namespace Busman\People\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Busman\Acl\Models\Role;

class Team extends Model
{
    use Notifiable;

    protected $fillable = ['name', 'slug', 'owner_id'];

    protected $hidden = [
        'card_brand',
        'card_last_four',
        'card_country',
        'billing_address',
        'billing_address_line_2',
        'billing_city',
        'billing_state',
        'billing_zip',
        'billing_country',
        'extra_billing_information',
    ];

    protected $casts = [
        'owner_id' => 'int',
        'trial_ends_at' => 'datetime',
    ];

    public function getEmailAttribute()
    {
        return $this->owner->email;
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function users()
    {
        return $this->belongsToMany(
            User::class, 'team_users', 'team_id', 'user_id'
        )->withPivot('role');
    }

    public function customers(){
        return $this->hasMany(Customer::class);
    }

    public function employees(){
        return $this->hasMany(Employee::class);
    }

    public function roles(){
        return $this->hasMany(Role::class);
    }

    public function services(){
        return $this->hasMany(Service::class);
    }

    public function jobs(){
        return $this->hasMany(Job::class);
    }

    public function shouldHaveOwnerVisibility()
    {
        $this->makeVisible([
            'card_brand',
            'card_last_four',
            'card_country',
            'billing_address',
            'billing_address_line_2',
            'billing_city',
            'billing_state',
            'billing_zip',
            'billing_country',
            'extra_billing_information',
        ]);
    }



    /**
     * Detach all of the users from the team and delete the team.
     *
     * @return void
     */
    public function detachUsersAndDestroy()
    {
        if ($this->subscribed()) {
            $this->subscription()->cancelNow();
        }

        $this->users()
            ->where('current_team_id', $this->id)
            ->update(['current_team_id' => null]);

        $this->users()->detach();

        $this->delete();
    }
}
