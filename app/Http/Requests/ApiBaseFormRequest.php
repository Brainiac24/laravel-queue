<?php
/**
 * Created by PhpStorm.
 * User: K_Hakimboev
 * Date: 07.06.2018
 * Time: 11:50
 */

namespace App\Http\Requests;


use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class ApiBaseFormRequest extends FormRequest
{

    protected $isShowCustomMessage = false;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract public function rules();

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    abstract public function authorize();

    public function wantsJson()
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        $message = 'Некоторые поля заполнены неверно!';


        if ($this->expectsJson()) {
            if ($this->isShowCustomMessage === true)
                throw new HttpResponseException(response()->apiError(compact('message')));
            else
                throw new HttpResponseException(response()->apiError(compact('message', 'errors')));
        }
    }

    public function response(array $errors)
    {

    }
}