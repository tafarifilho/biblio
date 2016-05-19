		<div class="form-group">
			{!! Form::label('predio', 'Nome do Prédio', array('class'=>'col-sm-2 control-label')) !!}
			<div class="col-sm-10">
				{!! Form::text('predio', null, array('id'=>'predio', 'class'=>'form-control', 'placeholder'=>'Nome')) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('endereco', 'Endereço', array('class'=>'col-sm-2 control-label')) !!}
			<div class="col-sm-10">
				{!! Form::text('endereco', null, array('id'=>'endereco', 'class'=>'form-control', 'placeholder'=>'Endereço')) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('numero', 'Número', array('class'=>'col-sm-2 control-label')) !!}
			<div class="col-sm-10">
				{!! Form::text('numero', null, array('id'=>'numero', 'class'=>'form-control', 'placeholder'=>'Número')) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('complemento', 'Complemento', array('class'=>'col-sm-2 control-label')) !!}
			<div class="col-sm-10">
				{!! Form::text('complemento', null, array('id'=>'complemento', 'class'=>'form-control', 'placeholder'=>'Complemento')) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('cidade', 'Cidade', array('class'=>'col-sm-2 control-label')) !!}
			<div class="col-sm-10">
				{!! Form::text('cidade', null, array('id'=>'cidade', 'class'=>'form-control', 'placeholder'=>'Cidade')) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('estado', 'Estado', array('class'=>'col-sm-2 control-label')) !!}
			<div class="col-sm-10">
				{!! Form::text('estado', null, array('id'=>'estado', 'class'=>'form-control', 'placeholder'=>'Sigla')) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('cep', 'CEP', array('class'=>'col-sm-2 control-label')) !!}
			<div class="col-sm-10">
				{!! Form::text('cep', null, array('id'=>'cep', 'class'=>'form-control', 'placeholder'=>'CEP')) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('tronco', 'Telefone Tronco', array('class'=>'col-sm-2 control-label')) !!}
			<div class="col-sm-10">
				{!! Form::text('tronco', null, array('id'=>'tronco', 'class'=>'form-control', 'placeholder'=>'Telefone')) !!}
			</div>
		</div>

		<div class="form-group">
			<div id="cadastrar" class="col-sm-offset-9 col-sm-3">
				<button type="submit" class="btn btn-success btn-lg col-sm-12">
					<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> {{ $tituloBotao }}
				</button>
			</div>
		</div>

