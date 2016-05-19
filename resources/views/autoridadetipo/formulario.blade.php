		<div class="form-group">
			{!! Form::label('tipo', 'Tipo de Autoridade', array('class'=>'col-sm-2 control-label')) !!}
			<div class="col-sm-10">
				{!! Form::text('tipo', null, array('id'=>'tipo', 'class'=>'form-control', 'placeholder'=>'Tipo')) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('tratamento', 'Tratamento', array('class'=>'col-sm-2 control-label')) !!}
			<div class="col-sm-10">
				{!! Form::text('tratamento', null, array('id'=>'tratamento', 'class'=>'form-control', 'placeholder'=>'Tratamento')) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('abreviado', 'Abreviatura', array('class'=>'col-sm-2 control-label')) !!}
			<div class="col-sm-10">
				{!! Form::text('abreviado', null, array('id'=>'abreviado', 'class'=>'form-control', 'placeholder'=>'Tratamento Abreviado')) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('prazo', 'Prazo', array('class'=>'col-sm-2 control-label')) !!}
			<div class="col-sm-10">
				{!! Form::text('prazo', null, array('id'=>'prazo', 'class'=>'form-control', 'placeholder'=>'Prazo')) !!}
			</div>
		</div>

		<div class="form-group">

			<div id="cadastrar" class="col-sm-offset-9 col-sm-3">
				<button type="submit" class="btn btn-success btn-lg col-sm-12">
					<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> {{ $tituloBotao }}
				</button>
			</div>

		</div>
