<?php

namespace App\Http\Requests;

use App\Enums\CellValue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCellRequest extends FormRequest
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
            'value'    => ['required', Rule::in(CellValue::getValues())],
            'opponent' => ['required', Rule::in(CellValue::getValues())],
        ];
    }

    /**
     * The current piece of the Player.
     *
     * @return string
     */
    public function playerPiece(): string
    {
        return $this->input('value');
    }

    /**
     * The current piece of the Robot.
     *
     * @return string
     */
    public function robotPiece(): string
    {
        return $this->input('opponent');
    }
}
