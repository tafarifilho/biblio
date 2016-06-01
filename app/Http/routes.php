<?php
/*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
| Basic Routes
|
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Home Route
|--------------------------------------------------------------------------
*/
Route::get('/', [
	'as'         => 'home',
	'middleware' => 'sentry',
	'uses'       => 'HomeController@index'
	]);

/*
|--------------------------------------------------------------------------
| User Desktop Route
|--------------------------------------------------------------------------
*/
Route::get('desktop', [
	'as'         => 'desktop',
	'middleware' => 'sentry',
	'uses'       => 'HomeController@index'
	]);

/*
|--------------------------------------------------------------------------
| Sobre Route
|--------------------------------------------------------------------------
*/
Route::get('/sobre', [
	'as'         => 'home',
	'middleware' => 'sentry',
	'uses'       => 'HomeController@sobre'
	]);

/*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
| Cargas Routes
|
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Carga Realizar GET
|--------------------------------------------------------------------------
*/
Route::get('carga/realizar', [
	'uses'       => 'CargasController@getRealizar',
	'as'         => 'carga.realizar',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Realizar Carga'],
	'hasAccess'  => ['carga.realizar']
	]);

/*
|--------------------------------------------------------------------------
| Carga Realizar POST
|--------------------------------------------------------------------------
*/
Route::post('carga/realizar', [
	'uses'       => 'CargasController@postRealizar',
	'as'         => 'carga.realizar.post',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Realizar Carga'],
	'hasAccess'  => ['carga.realizar']
	]);

/*
|--------------------------------------------------------------------------
| Carga Baixar GET
|--------------------------------------------------------------------------
*/
Route::get('carga/baixar', [
	'uses'       => 'CargasController@getBaixar',
	'as'         => 'carga.baixar',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Realizar Baixa'],
	'hasAccess'  => ['carga.baixar']
	]);

/*
|--------------------------------------------------------------------------
| Carga Realizar Baixa GET
|--------------------------------------------------------------------------
*/
Route::get('carga/realizarbaixa/{id}', [
	'uses'       => 'CargasController@getRealizarBaixa',
	'as'         => 'carga.realizarbaixa',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Realizar Baixa'],
	'hasAccess'  => ['carga.baixar']
	])->where('id', '[0-9]+');

/*
|--------------------------------------------------------------------------
| Carga Listar GET
|--------------------------------------------------------------------------
*/
Route::get('carga/listar', [
	'uses'       => 'CargasController@getListar',
	'as'         => 'carga.listar',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Listar Carga'],
	'hasAccess'  => ['carga.listar','carga.exibir','carga.imprimir']
	]);

/*
|--------------------------------------------------------------------------
| Carga Listar POST
|--------------------------------------------------------------------------
*/
Route::post('carga/listar', [
	'uses'       => 'CargasController@postListar',
	'as'         => 'carga.listar.post',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Listar Carga'],
	'hasAccess'  => ['carga.listar','carga.exibir','carga.imprimir']
	]);

/*
|--------------------------------------------------------------------------
| Carga Listar Abertas GET
|--------------------------------------------------------------------------
*/
Route::get('carga/listarabertas', [
	'uses'       => 'CargasController@getListarAbertas',
	'as'         => 'carga.listarabertas',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Listar Carga'],
	'hasAccess'  => ['carga.listar','carga.exibir','carga.imprimir']
	]);

/*
|--------------------------------------------------------------------------
| Carga Exibir GET
|--------------------------------------------------------------------------
*/
Route::get('carga/exibir/{carga}', [
	'uses'       => 'CargasController@getExibir',
	'as'         => 'carga.exibir',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Listar Carga'],
	'hasAccess'  => ['carga.listar','carga.exibir','carga.imprimir']
	])->where('carga', '[0-9]+');

/*
|--------------------------------------------------------------------------
| Carga Imprimir GET
|--------------------------------------------------------------------------
*/
Route::get('carga/imprimir/{carga}', [
	'uses'       => 'CargasController@getImprimir',
	'as'         => 'carga.imprimir',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Listar Carga'],
	'hasAccess'  => ['carga.listar','carga.exibir','carga.imprimir']
	])->where('carga', '[0-9]+');

/*
|--------------------------------------------------------------------------
| Carga Editar GET
|--------------------------------------------------------------------------
*/
Route::get('carga/editar/{id}', [
	'uses'       => 'CargasController@getEditar',
	'as'         => 'carga.editar',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Cargas'],
	'hasAccess'  => ['carga.editar','carga.apagar','carga.reativar']
	])->where('id', '[0-9]+');

/*
|--------------------------------------------------------------------------
| Carga Editar POST
|--------------------------------------------------------------------------
*/
Route::post('carga/editar/{id}', [
	'uses'       => 'CargasController@postEditar',
	'as'         => 'carga.editar.post',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Cargas'],
	'hasAccess'  => ['carga.editar','carga.apagar','carga.reativar']
	])->where('id', '[0-9]+');

/*
|--------------------------------------------------------------------------
| Carga Apagar GET
|--------------------------------------------------------------------------
*/
Route::get('carga/apagar/{id}', [
	'uses'       => 'CargasController@getApagar',
	'as'         => 'carga.apagar',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Cargas'],
	'hasAccess'  => ['carga.editar','carga.apagar','carga.reativar']
	])->where('id', '[0-9]+');

/*
|--------------------------------------------------------------------------
| Carga Reativar GET
|--------------------------------------------------------------------------
*/
Route::get('carga/reativar/{id}', [
	'uses'       => 'CargasController@getReativar',
	'as'         => 'carga.reativar',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Cargas'],
	'hasAccess'  => ['carga.editar','carga.apagar','carga.reativar']
	])->where('id', '[0-9]+');

/*
|--------------------------------------------------------------------------
| Carga Cobrar GET
|--------------------------------------------------------------------------
*/
Route::get('carga/cobrar', [
	'uses'       => 'CargasController@getCobrar',
	'as'         => 'carga.cobrar',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Realizar Cobrança'],
	'hasAccess'  => ['carga.cobrar','carga.renovar']
	]);

/*
|--------------------------------------------------------------------------
| Carga Cobrar POST
|--------------------------------------------------------------------------
*/
Route::post('carga/cobrar', [
	'uses'       => 'CargasController@postCobrar',
	'as'         => 'carga.cobrar.post',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Realizar Cobrança'],
	'hasAccess'  => ['carga.cobrar','carga.renovar']
	]);

/*
|--------------------------------------------------------------------------
| Carga Renovar GET
|--------------------------------------------------------------------------
*/
Route::get('carga/renovar', [
	'uses'       => 'CargasController@getRenovar',
	'as'         => 'carga.renovar',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Realizar Cobrança'],
	'hasAccess'  => ['carga.cobrar','carga.renovar']
	]);

/*
|--------------------------------------------------------------------------
| Carga Renovar POST
|--------------------------------------------------------------------------
*/
Route::post('carga/renovar', [
	'uses'       => 'CargasController@postRenovar',
	'as'         => 'carga.renovar.post',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Realizar Cobrança'],
	'hasAccess'  => ['carga.cobrar','carga.renovar']
	]);

/*
|--------------------------------------------------------------------------
| Carga Comentar GET
|--------------------------------------------------------------------------
*/
Route::get('carga/comentar', [
	'uses'       => 'CargasController@getComentar',
	'as'         => 'carga.comentar',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Realizar Cobrança'],
	'hasAccess'  => ['carga.cobrar','carga.renovar']
	]);

/*
|--------------------------------------------------------------------------
| Carga Comentar POST
|--------------------------------------------------------------------------
*/
Route::post('carga/comentar', [
	'uses'       => 'CargasController@postComentar',
	'as'         => 'carga.comentar.post',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Realizar Cobrança'],
	'hasAccess'  => ['carga.cobrar','carga.renovar']
	]);

/*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
| Autoridades Routes
|
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Autoridade API GET
|--------------------------------------------------------------------------
*/
Route::get('autoridade/api', [
	'uses'       => 'AutoridadesController@getApi',
	'as'         => 'autoridade.api',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Listar Autoridades'],
	'hasAccess'  => ['autoridade.api', 'autoridade.apitabela', 'autoridade.exibir', 'autoridade.listar', 'autoridade.imagem']
	]);

/*
|--------------------------------------------------------------------------
| Autoridade API TABELA GET
|--------------------------------------------------------------------------
*/



/*
|--------------------------------------------------------------------------
| Autoridade Cadastrar GET
|--------------------------------------------------------------------------
*/
Route::get('autoridade/cadastrar', [
	'uses'       => 'AutoridadesController@getCadastrar',
	'as'         => 'autoridade.cadastrar',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Autoridades'],
	'hasAccess'  => ['autoridade.cadastrar', 'autoridade.editar', 'autoridade.apagar', 'autoridade.reativar']
	]);

/*
|--------------------------------------------------------------------------
| Autoridade Cadastrar POST
|--------------------------------------------------------------------------
*/
Route::post('autoridade/cadastrar', [
	'uses'       => 'AutoridadesController@postCadastrar',
	'as'         => 'autoridade.cadastrar.post',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Autoridades'],
	'hasAccess'  => ['autoridade.cadastrar', 'autoridade.editar', 'autoridade.apagar', 'autoridade.reativar']
	]);

/*
|--------------------------------------------------------------------------
| Autoridade Listar GET
|--------------------------------------------------------------------------
*/
Route::get('autoridade/listar', [
	'uses'       => 'AutoridadesController@getListar',
	'as'         => 'autoridade.listar',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Listar Autoridades'],
	'hasAccess'  => ['autoridade.api', 'autoridade.apitabela', 'autoridade.exibir', 'autoridade.listar', 'autoridade.imagem']
	]);

/*
|--------------------------------------------------------------------------
| Autoridade Exibir GET
|--------------------------------------------------------------------------
*/
Route::get('autoridade/exibir/{id}', [
	'uses'       => 'AutoridadesController@getExibir',
	'as'         => 'autoridade.exibir',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Listar Autoridades'],
	'hasAccess'  => ['autoridade.api', 'autoridade.apitabela', 'autoridade.exibir', 'autoridade.listar', 'autoridade.imagem']
	])->where('id', '[0-9]+');

/*
|--------------------------------------------------------------------------
| Autoridade Editar GET
|--------------------------------------------------------------------------
*/
Route::get('autoridade/editar/{id}', [
	'uses'       => 'AutoridadesController@getEditar',
	'as'         => 'autoridade.editar',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Autoridades'],
	'hasAccess'  => ['autoridade.cadastrar', 'autoridade.editar', 'autoridade.apagar', 'autoridade.reativar']
	])->where('id', '[0-9]+');

/*
|--------------------------------------------------------------------------
| Autoridade Editar POST
|--------------------------------------------------------------------------
*/
Route::post('autoridade/editar', [
	'uses'       => 'AutoridadesController@postEditar',
	'as'         => 'autoridade.editar.post',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Autoridades'],
	'hasAccess'  => ['autoridade.cadastrar', 'autoridade.editar', 'autoridade.apagar', 'autoridade.reativar']
	]);

/*
|--------------------------------------------------------------------------
| Autoridade Apagar GET
|--------------------------------------------------------------------------
*/
Route::get('autoridade/apagar/{id}', [
	'uses'       => 'AutoridadesController@getApagar',
	'as'         => 'autoridade.apagar',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Autoridades'],
	'hasAccess'  => ['autoridade.cadastrar', 'autoridade.editar', 'autoridade.apagar', 'autoridade.reativar']
	])->where('carga', '[0-9]+');

/*
|--------------------------------------------------------------------------
| Autoridade Reativar GET
|--------------------------------------------------------------------------
*/
Route::get('autoridade/reativar/{id}', [
	'uses'       => 'AutoridadesController@getReativar',
	'as'         => 'autoridade.reativar',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Autoridades'],
	'hasAccess'  => ['autoridade.cadastrar', 'autoridade.editar', 'autoridade.apagar', 'autoridade.reativar']
	])->where('carga', '[0-9]+');

/*
|--------------------------------------------------------------------------
| Autoridade Imagens GET
|--------------------------------------------------------------------------
*/
Route::get('autoridade/imagemfull/{id}', [
	'uses'       => 'AutoridadesController@getImagemFull',
	'as'         => 'autoridade.imagemfull',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Listar Autoridades'],
	'hasAccess'  => ['autoridade.api', 'autoridade.apitabela', 'autoridade.exibir', 'autoridade.listar', 'autoridade.imagem']
	])->where('carga', '[0-9]+');
Route::get('autoridade/imagemmini/{id}', [
	'uses'       => 'AutoridadesController@getImagemMini',
	'as'         => 'autoridade.imagemmini',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Listar Autoridades'],
	'hasAccess'  => ['autoridade.api', 'autoridade.apitabela', 'autoridade.exibir', 'autoridade.listar', 'autoridade.imagem']
	])->where('carga', '[0-9]+');

/*
|--------------------------------------------------------------------------
| Autoridade Telefone GET
|--------------------------------------------------------------------------
*/
Route::get('autoridade/telefone/{id}', [
	'uses'       => 'AutoridadesController@getTelefone',
	'as'         => 'autoridade.telefone',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Autoridades'],
	'hasAccess'  => ['autoridade.cadastrar', 'autoridade.editar', 'autoridade.apagar', 'autoridade.reativar']
	])->where('id', '[0-9]+');

/*
|--------------------------------------------------------------------------
| Autoridade Telefone POST
|--------------------------------------------------------------------------
*/
Route::post('autoridade/telefone', [
	'uses'       => 'AutoridadesController@postTelefone',
	'as'         => 'autoridade.telefone.post',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Autoridades'],
	'hasAccess'  => ['autoridade.cadastrar', 'autoridade.editar', 'autoridade.apagar', 'autoridade.reativar']
	]);

/*
|--------------------------------------------------------------------------
| Autoridade Predio GET
|--------------------------------------------------------------------------
*/
Route::get('autoridade/predio/{id}', [
	'uses'       => 'AutoridadesController@getPredio',
	'as'         => 'autoridade.predio',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Autoridades'],
	'hasAccess'  => ['autoridade.cadastrar', 'autoridade.editar', 'autoridade.apagar', 'autoridade.reativar']
	])->where('id', '[0-9]+');

/*
|--------------------------------------------------------------------------
| Autoridade Predio POST
|--------------------------------------------------------------------------
*/
Route::post('autoridade/predio', [
	'uses'       => 'AutoridadesController@postPredio',
	'as'         => 'autoridade.predio.post',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Autoridades'],
	'hasAccess'  => ['autoridade.cadastrar', 'autoridade.editar', 'autoridade.apagar', 'autoridade.reativar']
	]);

/*
|--------------------------------------------------------------------------
| Autoridade Administrar Telefones GET
|--------------------------------------------------------------------------
*/
Route::get('autoridade/administrartelefones', [
	'uses'       => 'AutoridadesController@getAdministrarTelefones',
	'as'         => 'autoridade.administrartelefones',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Autoridades'],
	'hasAccess'  => ['autoridade.cadastrar', 'autoridade.editar', 'autoridade.apagar', 'autoridade.reativar']
	]);

/*
|--------------------------------------------------------------------------
|
| Obras Routes
|
|--------------------------------------------------------------------------
*/
Route::controller('obra', 'ObrasController');

/*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
| Usuários Routes
|
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Usuário Entrar GET
|--------------------------------------------------------------------------
*/
Route::get('usuario/entrar', [
	'uses'       => 'UsuariosController@getEntrar',
	'as'         => 'usuario.entrar',
	]);

/*
|--------------------------------------------------------------------------
| Usuário Entrar POST
|--------------------------------------------------------------------------
*/
Route::post('usuario/entrar', [
	'uses'       => 'UsuariosController@postEntrar',
	'as'         => 'usuario.entrar.post',
	]);

/*
|--------------------------------------------------------------------------
| Usuário Sair GET
|--------------------------------------------------------------------------
*/
Route::get('usuario/sair', [
	'uses'       => 'UsuariosController@getSair',
	'as'         => 'usuario.sair',
	]);

/*
|--------------------------------------------------------------------------
| Usuário Listar GET
|--------------------------------------------------------------------------
*/
Route::get('usuario/listar', [
	'uses'       => 'UsuariosController@getListar',
	'as'         => 'usuario.listar',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Usuários'],
	'hasAccess'  => ['usuario.listar','usuario.editar','usuario.apagar','usuario.reativar','usuario.grupos']
	]);

/*
|--------------------------------------------------------------------------
| Usuário Cadastrar GET
|--------------------------------------------------------------------------
*/
Route::get('usuario/cadastrar', [
	'uses'       => 'UsuariosController@getCadastrar',
	'as'         => 'usuario.cadastrar',
	]);

/*
|--------------------------------------------------------------------------
| Usuário Cadastrar POST
|--------------------------------------------------------------------------
*/
Route::post('usuario/cadastrar', [
	'uses'       => 'UsuariosController@postCadastrar',
	'as'         => 'usuario.cadastrar.post',
	]);

/*
|--------------------------------------------------------------------------
| Usuário Editar GET
|--------------------------------------------------------------------------
*/
Route::get('usuario/editar/{id}', [
	'uses'       => 'UsuariosController@getEditar',
	'as'         => 'usuario.editar',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Usuários'],
	'hasAccess'  => ['usuario.listar','usuario.editar','usuario.apagar','usuario.reativar','usuario.grupos']
	])->where('id', '[0-9]+');

/*
|--------------------------------------------------------------------------
| Usuário Editar POST
|--------------------------------------------------------------------------
*/
Route::post('usuario/editar/{id}', [
	'uses'       => 'UsuariosController@postEditar',
	'as'         => 'usuario.editar.post',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Usuários'],
	'hasAccess'  => ['usuario.listar','usuario.editar','usuario.apagar','usuario.reativar','usuario.grupos']
	])->where('id', '[0-9]+');

/*
|--------------------------------------------------------------------------
| Usuário Senha GET
|--------------------------------------------------------------------------
*/
Route::get('usuario/senha', [
	'uses'       => 'UsuariosController@getSenha',
	'as'         => 'usuario.senha',
	'middleware' => ['sentry'],
	]);

/*
|--------------------------------------------------------------------------
| Usuário Senha POST
|--------------------------------------------------------------------------
*/
Route::post('usuario/senha', [
	'uses'       => 'UsuariosController@postSenha',
	'as'         => 'usuario.senha.post',
	'middleware' => ['sentry'],
	]);

/*
|--------------------------------------------------------------------------
| Usuário Resetar senha GET
|--------------------------------------------------------------------------
*/
Route::get('usuario/resetar/{id}', [
	'uses'       => 'UsuariosController@getResetar',
	'as'         => 'usuario.resetar',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Usuários'],
	'hasAccess'  => ['usuario.listar','usuario.editar','usuario.apagar','usuario.reativar','usuario.grupos']
	])->where('id', '[0-9]+');

/*
|--------------------------------------------------------------------------
| Usuário Apagar GET
|--------------------------------------------------------------------------
*/
Route::get('usuario/apagar/{id}', [
	'uses'       => 'UsuariosController@getApagar',
	'as'         => 'usuario.apagar',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Usuários'],
	'hasAccess'  => ['usuario.listar','usuario.editar','usuario.apagar','usuario.reativar','usuario.grupos']
	])->where('id', '[0-9]+');

/*
|--------------------------------------------------------------------------
| Usuário Reativar GET
|--------------------------------------------------------------------------
*/
Route::get('usuario/reativar/{id}', [
	'uses'       => 'UsuariosController@getReativar',
	'as'         => 'usuario.reativar',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Usuários'],
	'hasAccess'  => ['usuario.listar','usuario.editar','usuario.apagar','usuario.reativar','usuario.grupos']
	])->where('id', '[0-9]+');

/*
|--------------------------------------------------------------------------
| Usuário Suspender GET
|--------------------------------------------------------------------------
*/
Route::get('usuario/suspender/{id}', [
	'uses'       => 'UsuariosController@getSuspender',
	'as'         => 'usuario.suspender',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Usuários'],
	'hasAccess'  => ['usuario.listar','usuario.editar','usuario.apagar','usuario.reativar','usuario.grupos']
	])->where('id', '[0-9]+');

/*
|--------------------------------------------------------------------------
| Usuário Liberar GET
|--------------------------------------------------------------------------
*/
Route::get('usuario/liberar/{id}', [
	'uses'       => 'UsuariosController@getLiberar',
	'as'         => 'usuario.liberar',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Usuários'],
	'hasAccess'  => ['usuario.listar','usuario.editar','usuario.apagar','usuario.reativar','usuario.grupos']
	])->where('id', '[0-9]+');

/*
|--------------------------------------------------------------------------
| Usuário Grupos GET
|--------------------------------------------------------------------------
*/
Route::get('usuario/grupos', [
	'uses'       => 'UsuariosController@getGrupos',
	'as'         => 'usuario.grupos',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Usuários'],
	'hasAccess'  => ['usuario.listar','usuario.editar','usuario.apagar','usuario.reativar','usuario.grupos']
	]);

/*
|--------------------------------------------------------------------------
| Usuário Grupos POST
|--------------------------------------------------------------------------
*/
Route::post('usuario/grupos', [
	'uses'       => 'UsuariosController@postGrupos',
	'as'         => 'usuario.grupos.post',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Usuários'],
	'hasAccess'  => ['usuario.listar','usuario.editar','usuario.apagar','usuario.reativar','usuario.grupos']
	]);

/*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
| Tipos Autoridades Routes
|
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Tipos Autoridades Listar GET
|--------------------------------------------------------------------------
*/

Route::get('autoridadetipo/listar', [
	'uses'       => 'AutoridadesTiposController@getListar',
	'as'         => 'autoridadetipo.listar',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Autoridades'],
	'hasAccess'  => ['autoridade.cadastrar', 'autoridade.editar', 'autoridade.apagar', 'autoridade.reativar']
	]);

/*
|--------------------------------------------------------------------------
| Tipos Autoridades Cadastrar GET
|--------------------------------------------------------------------------
*/

Route::get('autoridadetipo/cadastrar', [
	'uses'       => 'AutoridadesTiposController@getCadastrar',
	'as'         => 'autoridadetipo.cadastrar',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Autoridades'],
	'hasAccess'  => ['autoridade.cadastrar', 'autoridade.editar', 'autoridade.apagar', 'autoridade.reativar']
	]);

/*
|--------------------------------------------------------------------------
| Tipos Autoridades Cadastrar POST
|--------------------------------------------------------------------------
*/

Route::post('autoridadetipo/cadastrar', [
	'uses'       => 'AutoridadesTiposController@postCadastrar',
	'as'         => 'autoridadetipo.cadastrar.post',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Autoridades'],
	'hasAccess'  => ['autoridade.cadastrar', 'autoridade.editar', 'autoridade.apagar', 'autoridade.reativar']
	]);

/*
|--------------------------------------------------------------------------
| Tipos Autoridades Editar GET
|--------------------------------------------------------------------------
*/

Route::get('autoridadetipo/editar/{id}', [
	'uses'       => 'AutoridadesTiposController@getEditar',
	'as'         => 'autoridadetipo.editar',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Autoridades'],
	'hasAccess'  => ['autoridade.cadastrar', 'autoridade.editar', 'autoridade.apagar', 'autoridade.reativar']
	])->where('id', '[0-9]+');

/*
|--------------------------------------------------------------------------
| Tipos Autoridades Editar POST
|--------------------------------------------------------------------------
*/

Route::post('autoridadetipo/editar/{id}', [
	'uses'       => 'AutoridadesTiposController@postEditar',
	'as'         => 'autoridadetipo.editar.post',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Autoridades'],
	'hasAccess'  => ['autoridade.cadastrar', 'autoridade.editar', 'autoridade.apagar', 'autoridade.reativar']
	])->where('id', '[0-9]+');

/*
|--------------------------------------------------------------------------
| Tipos Autoridaes Apagar GET
|--------------------------------------------------------------------------
*/

Route::get('autoridadetipo/apagar/{id}', [
	'uses'       => 'AutoridadesTiposController@getApagar',
	'as'         => 'autoridadetipo.apagar',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Autoridades'],
	'hasAccess'  => ['autoridade.cadastrar', 'autoridade.editar', 'autoridade.apagar', 'autoridade.reativar']
	])->where('id', '[0-9]+');


/*
|--------------------------------------------------------------------------
| Tipos Autoridaes Reativar GET
|--------------------------------------------------------------------------
*/

Route::get('autoridadetipo/reativar/{id}', [
	'uses'       => 'AutoridadesTiposController@getReativar',
	'as'         => 'autoridadetipo.reativar',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Autoridades'],
	'hasAccess'  => ['autoridade.cadastrar', 'autoridade.editar', 'autoridade.apagar', 'autoridade.reativar']
	])->where('id', '[0-9]+');


/*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
| Prédios Routes
|
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Prédios APIT GET
|--------------------------------------------------------------------------
*/

Route::get('predio/api', [
	'uses'       => 'PrediosController@getApi',
	'as'         => 'predio.api',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Autoridades'],
	'hasAccess'  => ['autoridade.cadastrar', 'autoridade.editar', 'autoridade.apagar', 'autoridade.reativar']
	]);

/*
|--------------------------------------------------------------------------
| Prédios Listar GET
|--------------------------------------------------------------------------
*/

Route::get('predio/listar', [
	'uses'       => 'PrediosController@getListar',
	'as'         => 'predio.listar',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Autoridades'],
	'hasAccess'  => ['autoridade.cadastrar', 'autoridade.editar', 'autoridade.apagar', 'autoridade.reativar']
	]);

/*
|--------------------------------------------------------------------------
| Prédios Cadastrar GET
|--------------------------------------------------------------------------
*/

Route::get('predio/cadastrar', [
	'uses'       => 'PrediosController@getCadastrar',
	'as'         => 'predio.cadastrar',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Autoridades'],
	'hasAccess'  => ['autoridade.cadastrar', 'autoridade.editar', 'autoridade.apagar', 'autoridade.reativar']
	]);

/*
|--------------------------------------------------------------------------
| Prédios Cadastrar POST
|--------------------------------------------------------------------------
*/

Route::post('predio/cadastrar', [
	'uses'       => 'PrediosController@postCadastrar',
	'as'         => 'predio.cadastrar.post',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Autoridades'],
	'hasAccess'  => ['autoridade.cadastrar', 'autoridade.editar', 'autoridade.apagar', 'autoridade.reativar']
	]);

/*
|--------------------------------------------------------------------------
| Prédios Editar GET
|--------------------------------------------------------------------------
*/

Route::get('predio/editar/{id}', [
	'uses'       => 'PrediosController@getEditar',
	'as'         => 'predio.editar',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Autoridades'],
	'hasAccess'  => ['autoridade.cadastrar', 'autoridade.editar', 'autoridade.apagar', 'autoridade.reativar']
	])->where('id', '[0-9]+');

/*
|--------------------------------------------------------------------------
| Prédios Editar POST
|--------------------------------------------------------------------------
*/

Route::post('predio/editar/{id}', [
	'uses'       => 'PrediosController@postEditar',
	'as'         => 'predio.editar.post',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Autoridades'],
	'hasAccess'  => ['autoridade.cadastrar', 'autoridade.editar', 'autoridade.apagar', 'autoridade.reativar']
	])->where('id', '[0-9]+');

/*
|--------------------------------------------------------------------------
| Prédios Apagar GET
|--------------------------------------------------------------------------
*/

Route::get('predio/apagar/{id}', [
	'uses'       => 'PrediosController@getApagar',
	'as'         => 'predio.apagar',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Autoridades'],
	'hasAccess'  => ['autoridade.cadastrar', 'autoridade.editar', 'autoridade.apagar', 'autoridade.reativar']
	])->where('id', '[0-9]+');


/*
|--------------------------------------------------------------------------
| Prédios Reativar GET
|--------------------------------------------------------------------------
*/

Route::get('predio/reativar/{id}', [
	'uses'       => 'PrediosController@getReativar',
	'as'         => 'predio.reativar',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Autoridades'],
	'hasAccess'  => ['autoridade.cadastrar', 'autoridade.editar', 'autoridade.apagar', 'autoridade.reativar']
	])->where('id', '[0-9]+');


/*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
| Usuários Samba Routes
|
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Samba Grupo GET
|--------------------------------------------------------------------------
*/

Route::get('usuario/sambagrupo', [
	'uses'       => 'SambaController@getGrupo',
	'as'         => 'samba.grupo',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Usuários'],
	'hasAccess'  => ['usuario.listar','usuario.editar','usuario.apagar','usuario.reativar','usuario.grupos']
	]);

/*
|--------------------------------------------------------------------------
| Samba Grupo POST
|--------------------------------------------------------------------------
*/

Route::post('usuario/sambagrupo', [
	'uses'       => 'SambaController@postGrupo',
	'as'         => 'samba.grupo.post',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Usuários'],
	'hasAccess'  => ['usuario.listar','usuario.editar','usuario.apagar','usuario.reativar','usuario.grupos']
	]);

/*
|--------------------------------------------------------------------------
| Samba Grupo/Usuario GET
|--------------------------------------------------------------------------
*/

Route::get('usuario/sambagrupousuario/{id}', [
	'uses'       => 'SambaController@getGrupoUsuario',
	'as'         => 'samba.grupousuario',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Usuários'],
	'hasAccess'  => ['usuario.listar','usuario.editar','usuario.apagar','usuario.reativar','usuario.grupos']
	])->where('id', '[0-9]+');

/*
|--------------------------------------------------------------------------
| Samba Grupo/Usuario POST
|--------------------------------------------------------------------------
*/

Route::post('usuario/sambagrupousuario/{id}', [
	'uses'       => 'SambaController@postGrupoUsuario',
	'as'         => 'samba.grupousuario.post',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Usuários'],
	'hasAccess'  => ['usuario.listar','usuario.editar','usuario.apagar','usuario.reativar','usuario.grupos']
	])->where('id', '[0-9]+');

/*
|--------------------------------------------------------------------------
| Samba Grupo ApagarGET
|--------------------------------------------------------------------------
*/

Route::get('usuario/sambagrupoapagar/{grupo}', [
	'uses'       => 'SambaController@getGrupoApagar',
	'as'         => 'samba.grupoapagar',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Usuários'],
	'hasAccess'  => ['usuario.listar','usuario.editar','usuario.apagar','usuario.reativar','usuario.grupos']
	]);

/*
|--------------------------------------------------------------------------
| Samba Criar Usuário GET
|--------------------------------------------------------------------------
*/

Route::get('usuario/sambacriar/{id}', [
	'uses'       => 'SambaController@getCriarUsuario',
	'as'         => 'samba.usuariocriar',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Usuários'],
	'hasAccess'  => ['usuario.listar','usuario.editar','usuario.apagar','usuario.reativar','usuario.grupos']
	])->where('id', '[0-9]+');

/*
|--------------------------------------------------------------------------
| Samba Apagar Usuário POST
|--------------------------------------------------------------------------
*/

Route::get('usuario/sambaapagar/{id}', [
	'uses'       => 'SambaController@getApagarUsuario',
	'as'         => 'samba.usuarioapagar',
	'middleware' => ['sentry', 'inGroup', 'hasAccess'],
	'inGroup'    => ['Grupo de Administrar Usuários'],
	'hasAccess'  => ['usuario.listar','usuario.editar','usuario.apagar','usuario.reativar','usuario.grupos']
	])->where('id', '[0-9]+');


/*
|--------------------------------------------------------------------------
| Samba Usuário Senha GET
|--------------------------------------------------------------------------
*/

Route::get('usuario/sambasenha', [
	'uses'       => 'SambaController@getSenha',
	'as'         => 'samba.senha',
	'middleware' => ['sentry'],
	]);

/*
|--------------------------------------------------------------------------
| Samba Usuário Senha POST
|--------------------------------------------------------------------------
*/

Route::post('usuario/sambasenha', [
	'uses'       => 'SambaController@postSenha',
	'as'         => 'samba.senha.post',
	'middleware' => ['sentry'],
	]);

/*
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
|
| Consultas Routes
|
|--------------------------------------------------------------------------
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Consulta Resultado GET
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| Consulta Resultado POST
|--------------------------------------------------------------------------
*/

Route::post('consulta/resultado', [
	'uses'       => 'ConsultaController@postResultado',
	'as'         => 'consulta.resultado',
	'middleware' => ['sentry'],
	]);