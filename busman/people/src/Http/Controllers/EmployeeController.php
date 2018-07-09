<?php

namespace Busman\People\Http\Controllers;

use Busman\People\Http\Requests\EmployeeRequest;
use Busman\People\Models\Employee;
use Busman\People\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('employee_list');

        if ($request->q) {
            $employees = Employee::search($request->q)->get();
        } else {
            $employees = Employee::with('user')->get();
        }

        $pagEmployees = $employees->paginate($request);

        if ($request->q)
            $pagEmployees->load('user');

        return $pagEmployees->toArray();
    }

    public function store(EmployeeRequest $request)
    {
        $this->authorize('employee_store');

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => str_random(8),
            'last_read_announcements_at' => Carbon::now()
        ]);

        auth()->user()->currentTeam->users()->attach($user, ['role' => 'member']);

        $user->assignRole('employee');

        if ($request->image) {
            $user->addMedia(storage_path('app/'.$request->image))->toMediaCollection('profile');
        }

        /*$user->preferences()->create([
            'language' => auth()->user()->preferences->language,
            'team_id' => auth()->user()->currentTeam->id
        ]);*/

        $employeeData = $request->only(['department', 'meta']);
        $employeeData['team_id'] = auth()->user()->currentTeam->id;

        $employee = $user->employee()->create($employeeData);

        if (isset($request->uploads) && is_array($request->uploads) && !empty($request->uploads)) {
            foreach ($request->uploads as $upload) {
                $employee
                    ->addMedia(storage_path('app/'.$upload['path']))
                    ->usingName($upload['name'])
                    ->toMediaCollection('uploads');
            }
        }

        return $this->show($employee);
    }

    public function show(Employee $employee)
    {
        $this->authorize('employee_list');

        $user = $employee->user;

        $employee->load('user', 'user.roles');

        //$user->permissions = $user->getAllPermissions()->toArray();
        //$user->load('roles');

        //$employeeData = $employee->toArray();
        //$employeeData['id'] = $employee->id;
        //$employeeData['user'] = $user->toArray();

        if ($user->getMedia('profile')->first()) {
            if (env('MEDIA_DRIVER') == 's3') {
                $employee->image = Storage::temporaryUrl(
                    'media/'.$user->getMedia('profile')->first()->getPath(), now()->addMinutes(5)
                );
            } else {
                $employee->image = str_replace(storage_path('app/public'), url('/storage'), $user->getMedia('profile')->first()->getPath());
            }
        }

        return $employee->toArray();
    }

    public function update(EmployeeRequest $request, Employee $employee)
    {
        $this->authorize('employee_update');

        $employee->update($request->only(['department', 'meta']));

        $user = $employee->user;

        $newData = $request->only(['name', 'email', 'status']);

        $user->update($newData);

        // update or remove user profile image
        if ($request->image) {
            $user->clearMediaCollection('profile');
            $user->addMedia(storage_path('app/'.$request->image))->toMediaCollection('profile');
        } elseif ($request->remove_image && $request->remove_image == 'true') {
            $user->clearMediaCollection('profile');
        }

        if($request->remove_files){
            $employeeUploads = $employee->getMedia('uploads');
            if($employeeUploads){
                foreach ($employeeUploads as $employeeUpload) {
                    if(in_array($employeeUpload->getPath(), $request->remove_files)){
                        $employeeUpload->delete();
                    }
                }
            }
        }

        if (isset($request->uploads) && is_array($request->uploads) && !empty($request->uploads)) {
            foreach ($request->uploads as $upload) {
                if ($upload['rename_only']) {
                    $employeeUploads = $employee->getMedia('uploads');
                    if ($employeeUploads) {
                        foreach ($employeeUploads as $employeeUpload) {
                            if (in_array($employeeUpload->getPath(), $upload['path'])) {
                                $employeeUpload->name($upload['name']);
                                $employeeUpload->save();
                            }
                        }
                    }
                } else {
                    $employee->addMedia(storage_path('app/'.$upload['path']))->usingName($upload['name'])->toMediaCollection('uploads');
                }
            }
        }

        return $this->show($employee);
    }

    public function destroy(Employee $employee)
    {
        $this->authorize('employee_destroy');

        $user = $employee->user;

        if ($user->id == auth()->user()->id) {
            return response()->json(['message' => 'You cannot delete your own access'], 403);
        }

        $user->update([
            'username' => $user->id.'~'.$user->username,
            'email' => $user->id.'~'.$user->email,
        ]);

        $user->delete();
        $employee->delete();

        return response()->json('Deleted successfully', 200);
    }
}
