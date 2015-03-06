<?php
namespace BookieGG\Http\Requests;

class MatchEditRequest extends Request {

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
			'bo' => 'required|integer',
			'note' => 'digits_between:0,60'
		];
	}
}