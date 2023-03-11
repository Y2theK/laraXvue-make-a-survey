<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSurveyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $survey = $this->route('survey');
        if ($this->user()->id !== $survey->user_id) {
            return false;
        }
        return true;
    }
    // protected function prepareForValidation()
    // {
    //     $this->merge([
    //         'user_id' => $this->user()->id
    //     ]);
    // }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
   
    public function rules()
    {
        return [
            'title' => 'required|string|max:1000',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
            'user_id' => 'exists:users,id',
            'expired_date' => 'nullable|date|after:tomorrow',
            'image' => 'string|nullable'
        ];
    }
}
