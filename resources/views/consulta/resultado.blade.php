@extends('layouts.master')

@section('content')

	@if (count($obras) > 0)
		<ul>
		@foreach ($obras as $obra)
			<li>
				ID: {{ $obra->id }} - 
				<strong>
				@if(count($obra->v25) > 1)
					@foreach ($obra->v25 as $autor)
						{{ $autor['_'] }};
					@endforeach
				@else
					{{ $obra->v25['_'] }}
				@endif
				</strong>. 
				{{ $obra->v40['_'] }}
				</li>
		@endforeach
		</ul>
	@else
		Não existe resultado.
	@endif

@stop

@section('styles')
	
@stop

@section('scripts')
	
@stop