<?php

namespace Busman\People\Http\Controllers;

use Busman\People\Events\Customers\Created as CustomerCreated;
use Busman\People\Http\Requests\CustomerRequest;
use Busman\People\Models\Customer;
use Busman\People\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('customer_list');

        if ($request->q) { // Full-text search
            $customers = Customer::search($request->q)->get();
        } else {
            $customers = Customer::with('user')->get();
        }

        $pagCustomers = $customers->paginate($request);

        if ($request->q)
            $pagCustomers->load('user');

        return $pagCustomers->toArray();
    }

    public function store(CustomerRequest $request)
    {
        $this->authorize('customer_store');

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => str_random(8),
            'last_read_announcements_at' => Carbon::now()
        ]);

        $user->assignRole('customer');

        if ($request->image) {
            $user->addMedia(storage_path('app/'.$request->image))->toMediaCollection('profile');
        }

        $user->preferences()->create([
            'language' => auth()->user()->preferences->language,
            'team_id' => auth()->user()->currentTeam->id
        ]);

        $data = $request->only(['business_name', 'meta']);
        $data['team_id'] = auth()->user()->currentTeam->id;

        $customer = $user->customer()->create($data);

        if (isset($request->uploads) && is_array($request->uploads) && !empty($request->uploads)) {
            foreach ($request->uploads as $upload) {
                $customer
                    ->addMedia(storage_path('app/'.$upload['path']))
                    ->usingName($upload['name'])
                    ->toMediaCollection('uploads');
            }
        }

        event(new CustomerCreated($customer));

        return $this->show($customer);
    }

    public function show(Customer $customer)
    {
        $this->authorize('customer_list');

        $user = $customer->user->load(['roles', 'preferences']);

        $user->permissions = $user->getAllPermissions()->toArray();

        $customerData = $customer->toArray();
        $customerData['uploads'] = [];
        $customerData['user'] = $user->toArray();

        if ($user->getMedia('profile')->first()) {
            if (env('MEDIA_DRIVER') == 's3') {
                $customerData['image'] = Storage::temporaryUrl(
                    'media/'.$user->getMedia('profile')->first()->getPath(), now()->addMinutes(5)
                );
            } else {
                $customerData['image'] = str_replace(storage_path('app/public'), url('/storage'), $user->getMedia('profile')->first()->getPath());
            }
        }

        if ($customer->getMedia('uploads')->first()) {
            $medias = $customer->getMedia('uploads');

            foreach ($medias as $media) {
                if (env('MEDIA_DRIVER') == 's3') {
                    $url = Storage::temporaryUrl(
                        'media/'.$media->getPath(), now()->addMinutes(5)
                    );
                } else {
                    $url = str_replace(storage_path('app/public'), url('/storage'), $media->getPath());
                }

                array_push($customerData['uploads'], [
                    'url' => $url,
                    'path' => $media->getPath(),
                    'size' => $media->size,
                    'human_readable_size' => $media->human_readable_size,
                    'mime_type' => $media->mime_type,
                    'file_name' => $media->file_name,
                ]);
            }
        }

        return $customerData;
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        $this->authorize('customer_update');

        $newCustomerData = $request->only(['business_name', 'meta']);

        $customer->update($newCustomerData);

        $user = $customer->user()->get()->first();

        $newData = $request->only(['name', 'email', 'status']);

        // Update user info
        $user->update($newData);

        // update or remove user profile image
        if ($request->image) {
            $user->clearMediaCollection('profile');
            $user->addMedia(storage_path('app/'.$request->image))->toMediaCollection('profile');
        } elseif ($request->remove_image && $request->remove_image == 'true') {
            $user->clearMediaCollection('profile');
        }

        if($request->remove_files){
            $customerUploads = $customer->getMedia('uploads');
            if($customerUploads){
                foreach ($customerUploads as $customerUpload) {
                    if(in_array($customerUpload->getPath(), $request->remove_files)){
                        $customerUpload->delete();
                    }
                }
            }
        }

        if (isset($request->uploads) && is_array($request->uploads) && !empty($request->uploads)) {
            foreach ($request->uploads as $upload) {
                if ($upload['rename_only']) {
                    $customerUploads = $customer->getMedia('uploads');
                    if ($customerUploads) {
                        foreach ($customerUploads as $customerUpload) {
                            if (in_array($customerUpload->getPath(), $upload['path'])) {
                                $customerUpload->name($upload['name']);
                                $customerUpload->save();
                            }
                        }
                    }
                } else {
                    $customer->addMedia(storage_path('app/'.$upload['path']))->usingName($upload['name'])->toMediaCollection('uploads');
                }
            }
        }

        return $this->show($customer);
    }

    public function destroy(Customer $customer)
    {
        $this->authorize('customer_destroy');

        $user = $customer->user()->get()->first();

        // Test if can delete

        $user->update([
            'email' => $user->id.'~'.$user->email,
        ]);

        $user->delete();
        $customer->delete();

        return response()->json('Deleted successfully', 200);
    }
}
