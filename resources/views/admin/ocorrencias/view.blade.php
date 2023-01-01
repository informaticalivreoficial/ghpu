@extends('adminlte::page')

@section('title', 'Ocorrência')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1><i class="fas fa-user mr-2"></i> Perfil</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Painel de Controle</a></li>
            <li class="breadcrumb-item"><a href="{{route('ocorrencias.view', ['empresa' => $ocorrencia->empresaObject->id])}}">Ocorrências</a></li>
            <li class="breadcrumb-item active">Perfil</li>
        </ol>
    </div>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-12">
      <div class="card">          
        <div class="card-body">            
            <div class="row no-print">
                <div class="col-12">
                    <a href="javascript:window.print();" class="btn btn-default"><i class="fas fa-print"></i> Imprimir</a>                    
                </div>
            </div>
            <div class="row mt-3 text-muted">
                <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-4">
                    <p><b>Ocorrência:</b> {{$ocorrencia->titulo}}</p>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-4">
                    <p><b>Colaborador:</b> {{$ocorrencia->user->name}}</p>
                </div>
               <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-4">
                    <p><b>Data/Hora:</b> {{\Carbon\Carbon::parse($ocorrencia->created_at)->format('d/m/Y - H:i')}}</p>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-4">
                    <p><b>Empresa:</b> {{$ocorrencia->empresaObject->alias_name}}</p>
                </div>
            </div>
            <hr>
            <div class="row mt-3">
                <div class="col-12">
                    {!!$ocorrencia->content!!}
                </div>                                  
            </div>
        </div>
      </div>
    </div>
  </div>
@stop