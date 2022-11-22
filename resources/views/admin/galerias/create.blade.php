@extends('adminlte::page')

@section('title', 'Cadastrar Galeria')

@php
$config = [
    "height" => "300",
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
        <h1>Cadastrar Galeria</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Painel de Controle</a></li>
            <li class="breadcrumb-item active">Cadastrar Galeria</li>
        </ol>
    </div>
</div>
@stop

@section('content')
<!-- Main content -->
<section class="content text-muted">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
               @if($errors->all())
                    @foreach($errors->all() as $error)
                        @message(['color' => 'danger'])
                        {{ $error }}
                        @endmessage
                    @endforeach
                @endif 
            </div>            
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-teal card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-conteudo" role="tab" aria-controls="custom-tabs-conteudo" aria-selected="true">Conteúdo</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-imagens" role="tab" aria-controls="custom-tabs-imagens" aria-selected="false">Imagens</a>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="card-body">
                        <form action="{{ route('galerias.store') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                        @csrf   
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-conteudo" role="tabpanel" aria-labelledby="custom-tabs-conteudo-tab">
                                                       
                                <div class="row">
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label class="labelforms"><b>*Título:</b></label>
                                            <input class="form-control" name="titulo" placeholder="Título" value="{{old('titulo')}}">
                                        </div>
                                    </div>                                    
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="labelforms"><b>Status:</b></label>
                                            <select name="status" class="form-control">
                                                <option value="1" {{ (old('status') == '1' ? 'selected' : '') }}>Publicado</option>
                                                <option value="0" {{ (old('status') == '0' ? 'selected' : '') }}>Rascunho</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>                                
                                <div class="row">
                                    <div class="col-12">   
                                        <label class="labelforms"><b>Conteúdo:</b></label>
                                        <x-adminlte-text-editor name="content" v placeholder="Conteúdo da galeria..." :config="$config">{{ old('content') }}</x-adminlte-text-editor>                                                      
                                    </div>
                                </div> 
                            </div> 
                            
                            <div class="tab-pane fade" id="custom-tabs-imagens" role="tabpanel" aria-labelledby="custom-tabs-imagens-tab">
                                <div class="row mb-4">
                                    <div class="col-sm-12">                                        
                                        <div class="form-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="exampleInputFile" name="files[]" multiple>
                                                <label class="custom-file-label" for="exampleInputFile">Escolher Imagens</label>
                                            </div>
                                        </div>                                        
                                        <div class="content_image"></div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="row text-right">
                            <div class="col-12 mb-4">
                                <button type="submit" class="btn btn-success btn-lg"><i class="nav-icon fas fa-check mr-2"></i> Cadastrar Agora</button>
                            </div>
                        </div>
                        </form>
                    </div>
                    
                </div>
                
                
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
@stop

@section('css')
    <!--tags input-->
    <link rel="stylesheet" href="{{url('backend/plugins/jquery-tags-input/jquery.tagsinput.css')}}" />
    <link href="{{url(asset('backend/plugins/airdatepicker/css/datepicker.min.css'))}}" rel="stylesheet" type="text/css">
    <style type="text/css">
        div.tagsinput span.tag {
            background: #65CEA7 !important;
            border-color: #65CEA7;
            color: #fff;
            border-radius: 15px;
            -webkit-border-radius: 15px;
            padding: 3px 10px;
        }
        div.tagsinput span.tag a {
            color: #43886e;    
        }
        .property_image, .content_image {
            width: 100%;
            flex-basis: 100%;
            display: flex;
            justify-content: flex-start;
            flex-wrap: wrap;
        }
        .property_image .property_image_item, .content_image .property_image_item {
            flex-basis: calc(25% - 20px) !important;
            margin-bottom: 20px;
            margin-right: 20px;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            position: relative;
        }

        .property_image .property_image_item img, .content_image .property_image_item img {
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
        }
        .property_image .property_image_item .property_image_actions, .content_image .property_image_item .property_image_actions {
            position: absolute;
            top: 10px;
            left: 10px;
        }

        .embed {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            max-width: 100%;
        }
    </style>
@stop

@section('js')
<!--tags input-->
<script src="{{url('backend/plugins/jquery-tags-input/jquery.tagsinput.js')}}"></script>
<script src="{{url(asset('backend/plugins/airdatepicker/js/datepicker.min.js'))}}"></script>
<script src="{{url(asset('backend/plugins/airdatepicker/js/i18n/datepicker.pt-BR.js'))}}"></script>
    <script>
        $(function () {
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });         
            
            $('input[name="files[]"]').change(function (files) {

                $('.content_image').text('');

                $.each(files.target.files, function (key, value) {
                    var reader = new FileReader();
                    reader.onload = function (value) {
                        $('.content_image').append(
                            '<div id="list" class="property_image_item">' +
                            '<div class="embed radius" style="background-image: url(' + value.target.result + '); background-size: cover; background-position: center center;"></div>' +
                            '<div class="property_image_actions">' +
                                '<a href="javascript:void(0)" class="btn btn-danger btn-xs image-remove1 px-2"><i class="nav-icon fas fa-times"></i> </a>' +
                            '</div>' +
                            '</div>');
                            
                        $('.image-remove1').click(function(){
                            $(this).closest('#list').remove()
                        });
                    };
                    reader.readAsDataURL(value);
                });
            });
          
        });
    </script>
@stop