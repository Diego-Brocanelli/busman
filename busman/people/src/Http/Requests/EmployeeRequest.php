<?php

namespace Busman\People\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'image' => ['nullable',
                function($attribute, $value, $fail) {
                    if (!File::exists(storage_path('app/'.$value))) {
                        return $fail("File does not exists.");
                    } elseif (substr(File::mimeType(storage_path('app/'.$value)), 0, 5) != 'image') {
                        return $fail("File is not an image.");
                    }
                },
            ],
            'name' => 'required|max:255',
            'department' => 'nullable|max:255',
            'email' => 'required|email|unique:users,email',
            'remove_image' => 'boolean',
            'uploads.*.name' => 'required|max:255',
            'uploads.*.path' => [
                function($attribute, $value, $fail) {
                    if (!Storage::disk('local')->exists($value)) {
                        return $fail('File does not exists.');
                    }
                },
            ],
        ];

        if($this->method() == 'PUT') {
            $user = $this->employee->user()->get()->first();

            $rules['name'] = 'max:255';
            $rules['email'] = 'email|unique:users,email,'.$user->id;
        }

        return $rules;
    }
}
