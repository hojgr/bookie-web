<?php namespace BookieGG\Http\Requests;

class     MatchCreateRequest extends Request {

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
            'organizer' => 'required|integer|not_in:0',
            't1' => 'required|integer|not_in:0',
            't2' => 'required|integer|not_in:0',
            'bo' => 'required|integer',
            'start' => 'required',
        ];
    }

}
