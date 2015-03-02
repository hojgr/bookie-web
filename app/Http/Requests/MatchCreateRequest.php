<?php namespace BookieGG\Http\Requests;

class MatchCreateRequest extends Request {

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
			'organizer' => 'required|integer',
			't1' => 'required|integer',
			't2' => 'required|integer',
			'bo' => 'required|integer',
			'start' => 'required'
		];
	}

}
