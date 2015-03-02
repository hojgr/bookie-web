<?php namespace BookieGG\Http\Requests;

use BookieGG\Http\Requests\Request;

class TeamAddRequest extends Request {

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
			'name' => 'required',
			'logo' => 'required|image'
		];
	}

}