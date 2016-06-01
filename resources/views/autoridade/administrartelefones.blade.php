@extends('layouts.master')

@section('content')

    @if($predios)

        @foreach ($predios as $predio)

            <h1>{{ $predio->predio }}</h1>
            <table id="eventsTable{{$predio->id}}"
                    data-toggle="table"
                    data-search="true"
                    data-show-columns="true"
                    data-toolbar="#toolbar">

                    <thead>
                        <tr>
                            <th data-field="nome" data-sortable="true">nome</th>
                            <th data-field="cargo" data-sortable="true">cargo</th>
                            <th data-field="sala" data-sortable="true">sala</th>
                            <th data-field="telefones">telefones</th>
                            <th data-field="opcoes">opções</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($predio->autoridade->sortBy('nome') as $autoridade)

                            <tr>

                                <td>
                                    {{ $autoridade->nome }}
                                    @if ($autoridade->email)
                                        <br /><i>{{ $autoridade->email }}</i>
                                    @endif
                                </td>

                                <td>{{ $autoridade->tipo->tipo }}{{$autoridade->pivot->deleted_at}}</td>

                                <td>
                                    @if (count($autoridade->predio) > 1)
                                        <b>Autoridade com mais de um prédio. Observar!</b><br />
                                    @endif

                                    @foreach ($autoridade->predio as $predio)
                                        {{ $predio->pivot->sala }}<br />
                                    @endforeach
                                </td>

                                <td>
                                    @if ( count ($autoridade->telefone) > 0 )
                                        @foreach ($autoridade->telefone as $telefone)
                                            - {{ $telefone->telefone }} 
                                            @if ( $telefone->tipo_telefone )
                                                ({{ $telefone->tipo_telefone }})
                                            @endif
                                            <br />
                                        @endforeach
                                    @endif
                                </td>

                                <td>
                                    
                                    <a href="{!! route('autoridade.editar', [$autoridade->id]) !!}" class="btn btn-default btn-xs btn-warning" role="button" target="_blanc">
                                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                    </a>

                                    <a href="{!! route('autoridade.telefone', [$autoridade->id]) !!}" class="btn btn-default btn-xs btn-warning" role="button" target="_blanc">
                                        <span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span>
                                    </a>

                                    <a href="{!! route('autoridade.predio', [$autoridade->id]) !!}" class="btn btn-default btn-xs btn-warning" role="button" target="_blanc">
                                        <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
                                    </a>

                                </td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>

                <br /><br />

        @endforeach

    @endif

@stop

@section('styles')
    {!! Html::style('css/bootstrap-table.min.css') !!}
@stop

@section('scripts')
    {!! Html::script('js/vendor/bootstrap-table.min.js') !!}
@stop