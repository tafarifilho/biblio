<?php namespace App;

//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Model as Model;

class Obra extends Model {

	protected $connection = 'mongodb';
	protected $collection = 'dob';

	public function scopePesquisaLivro($query, $search)
	{
		$array = array('Livro', 
										'Livro ', 
										'livro', 
										'Tese', 
										'Folheto', 
										'Livro - Obra rara', 
										'Livro - obra rara', 
										' Livro - Obra rara', 
										'Livro - Obra Rara'
									);

			return $query->whereRaw(
				array(
					'$and' => array(
						array('v8._' => array('$in' => $array)),
						array('$text' => array('$search' => $search))
						)
					)
				);

/*
db.dob.find(
   {
    "v8._" : "Livro", 
   	$text: { $search: "meirelles \"mandado de segurança\"" } 
   },
   { score: { $meta: "textScore" } }
).sort( { 
	"v8._": 1, 
	score: { $meta: "textScore" } 
} );
*/

	}

	public function scopePesquisaAmpla($query, $search)
	{
		return $query->whereRaw(array('$text' => array('$search' => $search)));
	}

}
