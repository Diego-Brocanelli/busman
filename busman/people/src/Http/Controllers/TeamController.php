<?php

namespace Busman\People\Http\Controllers;

use Busman\People\Models\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->teams()->with('owner')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255'
        ]);

        $team = Team::create([
            'name' => $request->name,
            'owner_id' => $request->user()->id
        ]);

        $team->users()->attach($request->user(), ['role' => 'owner']);

        return $team;
    }

    public function show(Request $request, Team $team)
    {
        abort_unless($request->user()->ownsTeam($team), 404);

        $team->load('owner', 'users');

        if ($request->user()->ownsTeam($team)) {
            $team->load('subscriptions');

            $team->shouldHaveOwnerVisibility();
        }

        return $team;
    }

    public function update(Request $request, Team $team)
    {
        abort_unless($request->user()->ownsTeam($team), 404);

        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $team->forceFill([
            'name' => $request->name,
        ])->save();

        return $team;
    }

    public function destroy(Request $request, Team $team)
    {
        if (! $request->user()->ownsTeam($team)) {
            abort(403);
        }

        $team->detachUsersAndDestroy();

        return [
            'message' => 'Deleted Successfully'
        ];
    }
}
