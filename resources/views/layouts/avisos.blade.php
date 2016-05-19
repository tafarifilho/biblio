@if (Session::has('message'))
	@if(Session::get('tipo_message') == 'Sucesso')
		<div class="alert alert-success alert-dismissible" role="alert">
	@endif
	@if(Session::get('tipo_message') == 'Informação')
		<div class="alert alert-info alert-dismissible" role="alert">
	@endif
	@if(Session::get('tipo_message') == 'Aviso')
		<div class="alert alert-warning alert-dismissible" role="alert">
	@endif
	@if(Session::get('tipo_message') == 'Perigo')
		<div class="alert alert-danger alert-dismissible" role="alert">
	@endif

		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span></button>
		<strong>{{ Session::get('tipo_message') }}!</strong> {{ Session::get('message') }}
	</div>
@endif