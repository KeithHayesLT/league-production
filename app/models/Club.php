<?php

class Club extends Eloquent{

	protected $fillable = array('id','name','email','phone','website','logo','sport','description','add1','city','state','zip','processor_user','processor_pass');
	public static $rules = array(
		'name'					=>'required|min:3',
		'phone'					=>'required',
		'email'					=>'required',
		'website'				=>'required',
		'add1'					=>'required | min:2',
		'city'					=>'required | min:2',
		'state'					=>'required | min:2|max:2',
		'zip'						=>'required | digits:5',
		'logo'					=>'required',
		'processor_user'=>'required',
		'processor_pass'=>'required'
		);

	public function users() {
		return $this->belongsToMany('User')->withTimestamps();    
	}

	public function events()
	{
		return $this->hasMany('Evento');
	}

	// public function Programs()
	// {
	// 	return $this->hasMany('program');
	// }

	// public function Discounts()
	// {
	// 	return $this->hasMany('discount');
	// }
}