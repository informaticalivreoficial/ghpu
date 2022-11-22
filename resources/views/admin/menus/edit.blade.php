@extends('adminlte::page')

@php
//Variáveis
if($link->id_pai != null){
    $h1 = 'Editar Sub Link';
}else{
    $h1 = 'Editar Link';
}
@endphp

@section('title', "$h1")

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1><i class="fas fa-search mr-2"></i> {{$h1}}</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Painel de Controle</a></li>
            <li class="breadcrumb-item"><a href="{{route('menus.index')}}">Links</a></li>
            <li class="breadcrumb-item active">{{$h1}}</li>
        </ol>
    </div>
</div>
@stop

@section('content')    
        <div class="row">
            <div class="col-12">
               @if($errors->all())
                    @foreach($errors->all() as $error)
                        @message(['color' => 'danger'])
                        {{ $error }}
                        @endmessage
                    @endforeach
                @endif 

                @if(session()->exists('message'))
                    @message(['color' => session()->get('color')])
                    {{ session()->get('message') }}
                    @endmessage
                @endif
            </div>            
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-teal card-outline">
                    <div class="card-body">
                        <form action="{{ route('menus.update', [ 'id' => $link->id ]) }}" method="post" autocomplete="off">
                        @csrf
                        @method('PUT')                            
                        <div class="row mb-4">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="labelforms"><b>*Título do Link:</b></label>
                                    <input class="form-control" name="titulo" placeholder="Título do Link:" value="{{old('titulo') ?? $link->titulo}}">
                                </div>
                            </div>
                            @if(!empty($sublink) && $link->id_pai != null)  
                                <input type="hidden" name="tipo" value="{{$sublink->tipo}}"/> 
                                <div class="col-2">
                                    <div class="form-group">
                                        <label class="labelforms"><b>*Tipo:</b></label>
                                        <select name="tipo" class="form-control tipo_link">
                                            <option value=""> Selecione </option>
                                            <option value="pagina" {{ (old('pagina') == 'pagina' ? 'selected' : ($link->tipo == 'Página' ? 'selected' : '')) }}>Página</option>
                                            <option value="url" {{ (old('url') == 'url' ? 'selected' : ($link->tipo == 'URL' ? 'selected' : '')) }}>URL</option>
                                        </select>
                                    </div>
                                </div>                                 
                            @endif 
                            
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="labelforms"><b>Exibir no site?</b></label>
                                    <select class="form-control" name="status">
                                        <option value="1" {{(old('status') == '1' ? 'selected' : ($link->status == '1' ? 'selected' : ''))}}>Sim</option>
                                        <option value="0" {{(old('status') == '0' ? 'selected' : ($link->status == '0' ? 'selected' : ''))}}>Não</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                        <label class="labelforms"><b>Destino:</b></label> 
                                        <select class="form-control" name="target">
                                            <option value=""> Selecione </option>
                                            <option value="1" {{(old('target') == '1' ? 'selected' : ($link->target == '1' ? 'selected' : ''))}}>Nova Janela</option>
                                            <option value="0" {{(old('target') == '0' ? 'selected' : ($link->target == '0' ? 'selected' : ''))}}>Mesma Janela</option>
                                        </select>
                                    </select>
                                </div>
                            </div>                                                        
                        </div>  
                        <div class="row mb-4">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="labelforms"><b>Página:</b></label>
                                    <select name="post" class="form-control tipo_post">
                                        @if (!empty($paginas) && $paginas->count() > 0)
                                            <option value=""> Selecione </option>
                                            @foreach ($paginas as $pagina)
                                                <option value="{{$pagina->id}}" {{(old('post') == $pagina->id ? 'selected' : (!empty($link->post) && $pagina->id == $link->post ? 'selected' : ''))}}> {{$pagina->titulo}} </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>                            
                            <div class="col-5">
                                <div class="form-group">
                                    <label class="labelforms"><strong>URL</strong> <span style="font-size:10px; color:#C0C0C0;font-weight:normal;">Ex: http://www.dominio.com</span></label>
                                    <input class="form-control url_link" name="url" placeholder="URL:" value="{{ old('url') ?? $link->url }}">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="labelforms">&nbsp;</label>
                                    <button type="submit" style="width: 100%;" class="btn btn-success"><i class="nav-icon fas fa-check mr-2"></i> Atualizar Agora</button>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>                
                </div>
            </div>
        </div>
@endsection

@section('js')
    <script>
        $(function () {     
            
            $('.tipo_post').attr('disabled', true);

            var tipo_link = $(".tipo_link").val(); 
            if(tipo_link === 'pagina'){
                $('.tipo_post').attr('disabled', false);
                $('.url_link').attr('disabled', true);
            }         

            $('.tipo_link').on('change', function (){
                var link = this.value;
                if(link === 'pagina'){
                    $('.tipo_post').attr('disabled', false);
                    $('.url_link').attr('disabled', true);
                    $('.url_link').val('');
                }else if(link === 'url'){
                    $('.tipo_post').attr('disabled', true);
                    $('.url_link').attr('disabled', false);
                }            
            }); 
        });
    </script>
@endsection