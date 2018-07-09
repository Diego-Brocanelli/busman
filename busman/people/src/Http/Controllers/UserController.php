<?php

namespace Busman\People\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Busman\People\Models\Team;
use Busman\Spark\Spark;
use Busman\Spark\Contracts\Repositories\UserRepository;
use Busman\Spark\Contracts\Repositories\TeamRepository;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->only(
            'updateLastReadAnnouncementsTimestamp'
        );
    }

    /**
     * Get the current user of the application.
     *
     * @return Response
     */
    public function current()
    {
        $user = auth()->user();

        $user->permissions = $user->getAllPermissions()->pluck('name');
        $user->roles = $user->roles()->get()->pluck('slug');

        $user->current_team = $user->currentTeam;

        $user->preferences = $user->preferences()->get()->first()->toArray();
        if($user->image){
            $user->image = Storage::temporaryUrl(
                'media/'.$user->getMedia('profile')->first()->getPath(), now()->addMinutes(5)
            );
        }

        return $user;
    }

    /**
     * Update the last read announcements timestamp.
     *
     * @param  Request  $request
     * @return Response
     */
    public function updateLastReadAnnouncementsTimestamp(Request $request)
    {
        $request->user()->forceFill([
            'last_read_announcements_at' => Carbon::now(),
        ])->save();
    }

    /**
     * Switch the current team the user is viewing.
     *
     * @param  Request  $request
     * @param  \Busman\Spark\Team  $team
     * @return Response
     */
    public function switchCurrentTeam(Request $request,Team $team)
    {
        abort_unless($request->user()->onTeam($team), 404);

        $request->user()->switchToTeam($team);

        return ['message' => 'Switched'];
    }

    /**
     * Switch the current language.
     *
     * @param  Request  $request
     * @return Response
     */
    public function switchLang(Request $request)
    {
        $request->validate([
            'lang' => 'in:en,pt_BR,es'
        ]);

        auth()->user()->preferences->update([
            'language' => $request->lang
        ]);

        return response()->json('Language changed successfully', 200);
    }
}
