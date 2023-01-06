@extends('adminlte::page')

@section('title', 'Painel de Controle')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Painel de Controle</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Início</a></li>
            <li class="breadcrumb-item active">Painel de Controle</li>
        </ol>
    </div><!-- /.col -->
</div>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Últimas Ocorrências - {{auth()->user()->empresaObject->alias_name}}</a></li>                
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="activity">
                        @if (!empty($ocorrências) && $ocorrências->count() > 0)
                            @foreach ($ocorrências as $item)
                                @php
                                    if(!empty($item->user->avatar) && \Illuminate\Support\Facades\Storage::exists($item->user->avatar)){
                                        $cover = \Illuminate\Support\Facades\Storage::url($item->user->avatar);
                                    } else {
                                        if($item->user->genero == 'masculino'){
                                            $cover = url(asset('backend/assets/images/avatar5.png'));
                                        }elseif($item->user->genero == 'feminino'){
                                            $cover = url(asset('backend/assets/images/avatar3.png'));
                                        }else{
                                            $cover = url(asset('backend/assets/images/image.jpg'));
                                        }
                                    }
                                @endphp
                                <div class="post" style="{{($item->user->id == auth()->user()->id ? 'background: #ADFF2F !important;' : '')}}">
                                    <div class="user-block">
                                        <img class="img-circle img-bordered-sm" src="{{$cover}}" alt="{{$item->user->name}}">
                                        <span class="username">
                                            <a href="#">{{$item->user->name}}</a>
                                        </span>
                                        <span class="description">Publicado - {{\Carbon\Carbon::parse($item->created_at)->format('d/m - H:i')}}</span>
                                    </div>                    
                                    <p>{{$item->titulo}}</p>
                                    <p>
                                        <a href="#" class="link-black text-sm mr-2"><i class="fas fa-search mr-1"></i> Visualizar</a>
                                        <span class="float-right">
                                        <a href="#" class="link-black text-sm">
                                        <i class="far fa-comments mr-1"></i> Mensagens (5)
                                        </a>
                                        </span>
                                    </p>
                                    <form class="form-horizontal">
                                        <div class="input-group input-group-sm mb-0">
                                        <input class="form-control form-control-sm" placeholder="Escrever Mensagem">
                                        <div class="input-group-append">
                                        <button type="submit" class="btn btn-danger">Enviar</button>
                                        </div>
                                        </div>
                                    </form>
                                </div>
                            @endforeach
                        @endif        
                    </div>
                </div>        
            </div>
        </div>        
    </div>
</div>




</section>
@stop

@section('footer')

    <div class="pull-right hidden-xs">
      <b>Versão</b> {{env('VERSAO_SISTEMA')}}
    </div>
    <strong>Copyright © 2005 - {{date('Y')}} <a href="https://informaticalivre.com.br">Informática Livre</a>.</strong>
  
@endsection

@section('css')
<link rel="stylesheet" href="{{url(asset('backend/plugins/ekko-lightbox/ekko-lightbox.css'))}}">
<style>
    .info-box .info-box-content {   
        line-height: 120%;
    }
</style>
@endsection

@section('js')
<script src="{{url(asset('backend/plugins/ekko-lightbox/ekko-lightbox.min.js'))}}"></script>
    
@stop
