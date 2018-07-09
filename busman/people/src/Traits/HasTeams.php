<?php

namespace Busman\People\Traits;

use InvalidArgumentException;
use Busman\People\Models\Invitation;
use Busman\People\Models\Team;

trait HasTeams
{
    public function hasTeams()
    {
        return $this->teams()->count() > 0;
    }
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_users', 'user_id', 'team_id')->withPivot(['role'])->orderBy('name', 'asc');
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function onTeam(Team $team)
    {
        return $this->teams->contains($team);
    }

    public function ownsTeam(Team $team)
    {
        return $this->id == $team->owner_id;
    }

    public function ownedTeams()
    {
        return $this->hasMany(Team::class, 'owner_id');
    }

    public function roleOn(Team $team)
    {
        if ($this->onTeam($team)) {
            return $this->teams->find($team->id)->pivot->role;
        }

        return false;
    }

    public function roleOnCurrentTeam()
    {
        return $this->roleOn($this->currentTeam);
    }

    public function getCurrentTeamAttribute()
    {
        return $this->currentTeam();
    }

    public function currentTeam()
    {
        if (is_null($this->current_team_id) && $this->hasTeams()) {
            $this->switchToTeam($this->teams->first());

            return $this->currentTeam();
        } elseif (! is_null($this->current_team_id)) {
            $currentTeam = $this->teams->find($this->current_team_id);

            return $currentTeam ?: $this->refreshCurrentTeam();
        }
    }

    public function currentTeamOnTrial()
    {
        return $this->currentTeam() && $this->currentTeam()->onTrial();
    }

    public function ownsCurrentTeam()
    {
        return $this->currentTeam() && $this->currentTeam()->owner_id == $this->id;
    }

    public function switchToTeam(Team $team)
    {
        if (! $this->onTeam($team)) {
            throw new InvalidArgumentException(__("teams.user_doesnt_belong_to_team"));
        }

        $this->current_team_id = $team->id;

        $this->save();
    }

    public function refreshCurrentTeam()
    {
        $this->current_team_id = null;

        $this->save();

        return $this->currentTeam();
    }
}
