<?php namespace App;

//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Model as Model;

class Periodico extends Model {

	protected $connection = 'mongodb';
	protected $collection = 'ape';

}
