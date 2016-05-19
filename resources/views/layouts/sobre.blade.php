@extends('layouts.master')

@section('content')

	<div class="jumbotron">

		<h2>Sobre o Biblioteca</h2>
		<hr>

		<p><strong>Versão: </strong>1.0.4</p>
		<p><strong>Data da Versão: </strong>29/03/2016</p>

		<p><strong>Sistema</strong>

			<ul>
				<li>Sistema Operacional: BSD/Linux</li>
				<li>Distribuição: Ubuntu 14.04.2 LTS</li>
				<li>Servidor de páginas WEB: nginx 1.4.6</li>
				<li>Máquina virtual PHP: HHVM (Facebook) 3.7.2</li>
				<li>Servidor de Banco de Dados: MariaDB 10.0.20</li>
				<li>Servidor de Banco de Dados: mongoDB 3.0.4</li>
				<li>Servidor de Arquivos: Samba 4.1.6</li>
			</ul>

		</p>

		<p><strong>PHP</strong>

			<ul>
				<li>Gerenciador de Pacotes: Composer 1.0-dev</li>
				<li>Framework: Laravel 5.0.</li>
				<li>Package de Facade: illuminate/html</li>
				<li>Package de Controle de Usuário: cartalyst/sentry</li>
				<li>Package de Abstração de acesso ao MongoDB: jenssegers/mongodb</li>
				<li>Package de Manipulação de Imagem: intervention/image</li>
			</ul>

		</p>

		<p><strong>Javascript</strong>

			<ul>
				<li>jQuery</li>
				<li>Typeahead (Twitter)</li>
				<li>Bootstrap (Twitter)</li>
				<li>Handlebars</li>
				<li>Bootstrap-Table</li>
			</ul>

		</p>

		<p><strong>Agradecimento</strong>

			<ul>
			</ul>

		</p>

		<p><strong>ChangeLog</strong><p>

		<p>29/03/2016 - 1.0.4</p>
			<ul>
				<li>Criada opção de Listar Cargas em Aberto.</li>
				<li>Alterado caracteres mínimos para nome de pessoas nos Requests de Carga.</li>
			</ul>

		<p>25/08/2015 - 1.0.3</p>
			<ul>
				<li>Realizar Carga. O número da carga (STAMP) estava dentro do looping para realizar carga, causando diferença do número dentro de uma mesma carga.</li>
			</ul>

		<p>14/07/2015 - 1.0.2</p>
			<ul>
				<li>Imprimir Recibo de Mala. Inserir nome de autoridade de carga, quando o destinatário for outra autoridade.</li>
				<li>Imprimir Recibo de Mala. Destacar com parenteses o tipo de autoridade.</li>
			</ul>

		<p>25/06/2015 - 1.0.1</p>
			<ul>
				<li>Lista de cargas na exibição da autoridade transformada em tabela.</li>
				<li>Exibir Grupos/Samba existentes ao incluir/editar Grupos/Samba do Usuário.</li>
				<li>Exibir lista de diretórios/grupos do Samba.</li>
				<li>Criado sistema de comentários sobre cargas (menu/route/controller/view/JS)</li>
			</ul>

		<p>22/06/2015 - 1.0.0</p>
			<ul>
				<li>Versão inicial.</li>
			</ul>


	</div>

@stop

@section('styles')

@stop

@section('scripts')

@stop