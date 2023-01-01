@extends('adminlte::page')

@section('title', 'Editar Modelo de Ocorrência')

@php
$config = [
    "height" => "500",
    "fontSizes" => ['8', '9', '10', '11', '12', '14', '18'],
    "lang" => 'pt-BR',
    "toolbar" => [
        // [groupName, [list of button]]
        ['style', ['style']],
        ['fontname', ['fontname']],
        ['fontsize', ['fontsize']],
        ['style', ['bold', 'italic', 'underline', 'clear']],
        //['font', ['strikethrough', 'superscript', 'subscript']],        
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video','hr']],
        ['view', ['fullscreen', 'codeview']],
    ],
]
@endphp

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1><i class="fas fa-search mr-2"></i> Editar Modelo de Ocorrência</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Painel de Controle</a></li>
            <li class="breadcrumb-item"><a href="{{route('modelos.index')}}">Modelos</a></li>
            <li class="breadcrumb-item active">Editar Modelo de Ocorrência</li>
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
                        <form action="{{ route('modelos.update', $modelo->id) }}" method="post" autocomplete="off">
                        @csrf
                        @method('PUT')                         
                        <input type="hidden" name="update_user" value="{{Auth::user()->id}}">                                              
                        <div class="row mb-2">
                            <div class="col-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>*Título:</b></label>
                                    <input class="form-control" name="titulo" placeholder="Título:" value="{{old('titulo') ?? $modelo->titulo}}">
                                </div>
                            </div>                             
                            <div class="col-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>*Empresa:</b></label>
                                    <select name="empresa" class="form-control tipo_link">
                                        <option value="">Selecione</option>
                                        @foreach($empresas as $empresa)                                            
                                            <option value="{{ $empresa->id }}" {{ (old('empresa') == $empresa->id ? 'selected' : ($empresa->id == $modelo->empresa ? 'selected' : '')) }}>
                                                {{ $empresa->alias_name }}
                                            </option>                                                                                       
                                        @endforeach
                                    </select>
                                </div>
                            </div> 
                            <div class="col-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label class="labelforms text-muted">&nbsp;</label>
                                    <button type="submit" style="width: 100%;" class="btn btn-success"><i class="nav-icon fas fa-check mr-2"></i> Editar Agora</button>
                                </div>
                            </div>                                               
                        </div>  
                        <div class="row mb-4">
                            <div class="col-12">   
                                <label class="labelforms text-muted"><b>Conteúdo:</b></label>
                                <x-adminlte-text-editor name="content" v placeholder="Conteúdo..." :config="$config">{{ old('content') ?? $modelo->content }}</x-adminlte-text-editor>                                                      
                            </div> 
                        </div>
                        </form>
                    </div>                
                </div>
            </div>
        </div>
@endsection

@section('js')
    
@endsection