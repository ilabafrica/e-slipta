<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Partner;

class PartnerRequest extends Request {

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
		$id = $this->ingnoreId();
		return [
            'name'   => 'required|unique:partners,name,'.$id,
            'head'   => 'required|unique:partners,head,'.$id,
            'contact'   => 'required|unique:partners,contact,'.$id,
        ];
	}
	/**
	* @return \Illuminate\Routing\Route|null|string
	*/
	public function ingnoreId(){
		$id = $this->route('partner');
		$name = $this->input('name');
		return Partner::where(compact('id', 'name'))->exists() ? $id : '';
	}

}
