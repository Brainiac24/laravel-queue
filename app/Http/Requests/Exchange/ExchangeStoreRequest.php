<?php

namespace App\Http\Requests\Exchange;

use App\Http\Requests\ApiBaseFormRequest;

class ExchangeStoreRequest extends ApiBaseFormRequest
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
        return [
            'handler' => 'required|alpha_dash',
            'with_queue' => 'required|boolean',
            'payload' => 'required|array',
            'available_at' => 'date|nullable',
            'hash' => 'required|alpha_num',
            'datetime' => 'required|date_format:ymdHis|after:yesterday',
        ];
    }
}
