@extends('adminlte::page')

@section('title', 'Editar Ocorrência')

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
        <h1><i class="fas fa-search mr-2"></i> Editar Ocorrência</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Painel de Controle</a></li>
            <li class="breadcrumb-item"><a href="{{route('ocorrencias.index')}}">Ocorrências</a></li>
            <li class="breadcrumb-item active">Editar Ocorrência</li>
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
                        <form action="{{ route('ocorrencias.update', $ocorrencia->id) }}" method="post" autocomplete="off">
                        @csrf
                        @method('PUT')                      
                                                                      
                        <div class="row mb-4">
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>*Título:</b></label>
                                    <input class="form-control" name="titulo" placeholder="Título:" value="{{old('titulo') ?? $ocorrencia->titulo}}">
                                </div>
                            </div>
                            @if (Auth::user()->superadmin == 1 || Auth::user()->admin == 1)
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>*Colaborador:</b></label>
                                    <select name="colaborador" class="form-control tipo_link">
                                        <option value="">Selecione o colaborador</option>
                                        @foreach($users as $user)
                                            @if (Auth::user()->id != $user->id)
                                            <option value="{{ $user->id }}" {{ (old('colaborador') == $user->id ? 'selected' : ($user->id == $ocorrencia->colaborador ? 'selected' : '')) }}>
                                                {{ $user->name }} - ({{ $user->empresaObject->alias_name ?? '' }})
                                            </option>
                                            @endif                                            
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @else
                                <input type="hidden" name="colaborador" value="{{Auth::user()->id}}">
                            @endif 
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>*Selecione um Modelo:</b></label>
                                    <select name="modelo" class="form-control j_modelo">
                                        <option value="">Selecione</option>
                                        <option value="0">Em Branco</option>
                                        @foreach($modelos as $modelo)                                            
                                            <option value="{{ $modelo->id }}" {{ (old('modelo') == $modelo->id ? 'selected' : ($modelo->id == $ocorrencia->template ? 'selected' : '')) }}>
                                                {{ $modelo->titulo }}
                                            </option>                                                                                       
                                        @endforeach
                                    </select>
                                </div>
                            </div> 
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="labelforms text-muted">&nbsp;</label>
                                    <button type="submit" style="width: 100%;" class="btn btn-success"><i class="nav-icon fas fa-check mr-2"></i> Atualizar Agora</button>
                                </div>
                            </div>                                               
                        </div>  
                        <div class="row mb-4 row-modelo">
                            <div class="col-12">   
                                <label class="labelforms text-muted"><b>Conteúdo:</b></label>
                                <x-adminlte-text-editor name="content"  :config="$config">{{ old('content') ?? $ocorrencia->content }}</x-adminlte-text-editor>                                                      
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

            //$('.row-modelo').css("display","none");

            $('.j_modelo').on('change', function (){
                var modelo = this.value;
                if(modelo === '0'){
                    $('.row-modelo').css("display","block");
                    $('.note-editable').html('');
                }else{
                    $.ajax({
                        url: "{{ route('modelos.response') }}",
                        data:{ id: modelo},
                        type: 'GET',
                        dataType: 'JSON',
                        beforeSend: function(){
                            $(".btn-success").attr("disabled", true);
                            $('.btn-success').html("Carregando...");                
                            $('.alert').fadeOut(500, function(){
                                $(this).remove();
                            });
                        },
                        success: function(resposta){
                            if(resposta.sucess){
                                $('.row-modelo').css("display","block");                   
                                $('.note-editable').html(resposta.content);
                                $('textarea[name="content"]').html(resposta.content);                   
                            }else{
                                $('#js-result').html('<div class="alert alert-success error-msg">'+ resposta.error +'</div>');
                                $('.error-msg').fadeIn();   
                            }
                        },
                        complete: function(resposta){
                            $(".btn-success").attr("disabled", false);
                            $('.btn-success').html("<i class=\"nav-icon fas fa-check mr-2\"></i> Cadastrar Agora");                                
                        }
                    });
                }            
            }); 
        });
    </script>
@endsection