@if(\Sentry::check())
	<nav class="navbar navbar-default hidden-print">
		<div class="container-fluid">

			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1">
					<span class="sr-only">Home</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/">Biblioteca</a>
			</div>

			<div class="collapse navbar-collapse" id="navbar-collapse-1">

				@if($usuarioAtual->inGroup(\Sentry::findGroupByName('Grupo de Listar Carga')))
					<ul class="nav navbar-nav">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-book"> Carga </span><span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">

								@if($usuarioAtual->inGroup(\Sentry::findGroupByName('Grupo de Realizar Carga')))
									<li><a href="{!! route('carga.realizar') !!}"><span class="glyphicon glyphicon-thumbs-up"> Realizar</a></span></li>
								@endif

								@if($usuarioAtual->inGroup(\Sentry::findGroupByName('Grupo de Realizar Baixa')))
									<li><a href="{!! route('carga.baixar') !!}"><span class="glyphicon glyphicon-thumbs-down"> Baixar</span></a></li>
								@endif

								@if($usuarioAtual->inGroup(\Sentry::findGroupByName('Grupo de Listar Carga')))
									<li><a href="{!! route('carga.listar') !!}"><span class="glyphicon glyphicon-search"> Listar</span></a></li>
								@endif

								@if($usuarioAtual->inGroup(\Sentry::findGroupByName('Grupo de Listar Carga')))
									<li><a href="{!! route('carga.listarabertas') !!}"><span class="glyphicon glyphicon-search"> Listar Abertas</span></a></li>
								@endif

								@if($usuarioAtual->inGroup(\Sentry::findGroupByName('Grupo de Realizar Cobrança')))
									<li><a href="{!! route('carga.cobrar') !!}"><span class="glyphicon glyphicon-bell"> Cobrar</span></a></li>
									<li><a href="{!! route('carga.renovar') !!}"><span class="glyphicon glyphicon-refresh"> Renovar</span></a></li>
									<li><a href="{!! route('carga.comentar') !!}"><span class="glyphicon glyphicon-edit"> Comentar</span></a></li>
								@endif							
							</ul>
						</li>
					</ul>
				@endif

				@if($usuarioAtual->inGroup(\Sentry::findGroupByName('Grupo de Listar Autoridades')))
					<ul class="nav navbar-nav">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-king"> Autoridade </span><span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{!! route('autoridade.listar') !!}"><span class="glyphicon glyphicon-search"> Listar</span></a></li>
								@if($usuarioAtual->inGroup(\Sentry::findGroupByName('Grupo de Administrar Autoridades')))
									<li><a href="{!! route('autoridade.cadastrar') !!}"><span class="glyphicon glyphicon-plus"> Cadastrar</span></a></li>
									<li><a href="{!! route('predio.listar') !!}"><span class="glyphicon glyphicon-home"> Predio Listar</span></a></li>
									<li><a href="{!! route('predio.cadastrar') !!}"><span class="glyphicon glyphicon-home"> Predio Cadastrar</span></a></li>
									<li><a href="{!! route('autoridadetipo.listar') !!}"><span class="glyphicon glyphicon-briefcase"> Tipo Listar</span></a></li>
									<li><a href="{!! route('autoridadetipo.cadastrar') !!}"><span class="glyphicon glyphicon-briefcase"> Tipo Cadastrar</span></a></li>
								@endif
							</ul>
						</li>
					</ul>
				@endif
	
				<ul class="nav navbar-nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-zoom-in"> Consultar </span><span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">

						</ul>
					</li>
				</ul>

				@if($usuarioAtual->inGroup(\Sentry::findGroupByName('Grupo de Administrar Usuários')))
					<ul class="nav navbar-nav">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-user"> Usuários </span><span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ route('usuario.listar') }}"><span class="glyphicon glyphicon-search"> Listar</span></a></li>
								<li><a href="{{ route('usuario.cadastrar') }}"><span class="glyphicon glyphicon-plus"> Cadastrar</span></a></li>
								<li><a href="{{ route('samba.grupo') }}"><span class="glyphicon glyphicon-list-alt"> Grupo/Samba</span></a></li>
							</ul>
						</li>
					</ul>
				@endif

				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ $usuarioAtual->last_name }}<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="/sobre"><span class="glyphicon glyphicon-heart"> Sobre Biblioteca</span></a></li>
							<li><a href="{{ route('usuario.senha') }}"><span class="glyphicon glyphicon-lock"> Alterar Senha</a></li>
							@if ($usuarioAtual->samba == 1)
								<li><a href="{{ route('samba.senha') }}"><span class="glyphicon glyphicon-folder-open"> Alterar Senha/Samba</a></li>
							@endif
							<li><a href="{!! route('usuario.sair') !!}"><span class="glyphicon glyphicon-share-alt"> Sair</span></a></li>
						</ul>
					</li>
				</ul>

			</div>
		</div>
	</nav>
@endif
