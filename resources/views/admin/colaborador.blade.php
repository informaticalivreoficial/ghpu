@extends('adminlte::page')

@section('title', 'Painel de Controle')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0 text-dark">Painel de Controle</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Início</a></li>
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
                <div class="row">
                    <div class="col-6">
                        <h5>Últimas Ocorrências - <b>{{auth()->user()->empresaObject->alias_name}}</b></h5>
                    </div>
                    <div class="col-6 text-right">
                        <a href="{{route('ocorrencias.create')}}" class="btn btn-default"><i class="fas fa-plus mr-2"></i> Cadastrar Ocorrência</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">                
                        @if(session()->exists('message'))
                            @message(['color' => session()->get('color')])
                                {{ session()->get('message') }}
                            @endmessage
                        @endif
                    </div>            
                </div>
                
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active scrolling-pagination" id="activity">
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
                                <div class="post" style="{{($item->user->id == auth()->user()->id ? 'background: #F0FFFF !important;' : '')}}">
                                    <div class="user-block">
                                        <img class="img-circle img-bordered-sm" src="{{$cover}}" alt="{{$item->user->name}}">
                                        <span class="username">
                                            <a href="{{route('users.view-colaborador',['id' => $item->user->id])}}">{{$item->user->name}}</a>
                                            @if ($item->user->id == auth()->user()->id) - 
                                                <a href="{{route('ocorrencias.edit',['id' => $item->id])}}" class="text-right"><i class="fas fa-pen"></i></a>
                                            @endif
                                        </span>
                                        <span class="description">Publicado - {{\Carbon\Carbon::parse($item->created_at)->format('d/m - H:i')}}</span>                                                                                
                                    </div>                    
                                    <p>{{$item->titulo}}</p>
                                    <p>
                                        <a href="#" data-id="{{$item->id}}" data-toggle="modal" data-target="#modal-default" class="link-black text-sm mr-2 s"><i class="fas fa-search mr-1"></i> Visualizar</a>
                                        <span class="float-right">
                                            <a href="#" data-id="{{$item->id}}" class="link-black text-sm open">
                                                <i class="far fa-comments mr-1"></i> Mensagens (<span id="countComment{{$item->id}}">{{$item->comentariosCount()}}</span>) <span class="msg{{$item->id}}"> ↓</span>
                                            </a>
                                        </span>
                                    </p>
                                    <div class="resposta{{$item->id}}" style="display: none;"></div>
                                    <form method="post" action="" autocomplete="off" class="form-horizontal j_formcomment">
                                        @csrf 
                                        <div class="input-group input-group-sm mb-0">
                                            <input type="hidden" class="noclear" name="user" value="{{auth()->user()->id}}" />
                                            <input type="hidden" class="noclear" name="ocorrencia" value="{{$item->id}}" />
                                            <input type="hidden" class="noclear" name="status" value="1" />
                                            <input class="form-control form-control-sm" name="content" placeholder="Escrever Mensagem">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-danger btn-comment noclear">Enviar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endforeach
                            @if($ocorrências->hasPages())
                                {{$ocorrências->links()}}  
                            @endif
                        @endif        
                    </div>
                </div>        
            </div>
        </div>        
    </div>
</div>


<div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"> 
            <div class="modal-header">
                <h4 class="modal-title"><span class="j_param_titulo"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span class="j_param_data"></span>
            </div>
            <div class="modal-footer justify-content-between">
                <p>
                    Visualizado por: <span class="j_param_assinatura"></span>
                </p>
                <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
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
    <style> 
        .link-black:focus{
            color: #6c757d;
        }
        .jscroll-added{
            margin-top: 10px;
        }
    </style>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>
<script>
    // Paginação infinita
    $('ul.pagination-custom').hide();
    $(function() {
        $('.scrolling-pagination').jscroll({
            autoTrigger: true,
            padding: 0,
            nextSelector: '.pagination-custom li.active + li a',
            contentSelector: 'div.scrolling-pagination',
            callback: function() {
                $('ul.pagination-custom').remove();
            }
        });
    });          
</script>

<script>
    $(function () {

        $('.open').on('click', function (event) {
            event.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: "{{ route('loadComentarios') }}",
                data: {
                    'id': id
                },
                type: 'GET',
                dataType: 'JSON',
                success: function(data){    
                    var fragment="";                
                    if(data.length !== 0){
                        $('.resposta'+data[1].id).html('');
                        $.each(data[0], function (k, value) {                            
                            fragment +="<p class=\"pl-3\"><b>"+ value.user +"</b><br> "+ value.content +" </p>";
                        });
                        $('.resposta'+data[1].id).append(fragment);
                        box = $(".resposta"+data[1].id); 
                        button = $('.msg'+data[1].id);                        
                        if (box.css("display") !== "none") {
                            button.text(" ↓");
                        } else {
                            button.text(" ↑");
                        }
                        box.slideToggle();   
                    }
                }
            });
        });

        $(document).on('click', '[data-toggle="modal"]', function(event) {
            event.preventDefault();
            var id = $(this).data('id');

            $.ajax({
                url: "{{ route('ocorrenciaView') }}",
                data: {
                    'id': id
                },
                type: 'GET',
                dataType: 'JSON',
                success: function(data){                                       
                    if(data.titulo){
                        $('.j_param_assinatura').html('');
                        var fragment="";
                        $('.j_param_data').html(data.content);                  
                        $('.j_param_titulo').html(data.titulo); 
                        $.each(data.assinatura, function (k, value) { 
                            fragment +="<b>"+ value +"</b>";
                        });

                        $('.j_param_assinatura').append(fragment);                  
                    }
                }
            });
        });

        $('.j_formcomment').submit(function (){
            var form = $(this);
            var dataString = $(form).serialize();

            $.ajax({
                url: "{{ route('sendComment') }}",
                data: dataString,
                type: 'POST',
                dataType: 'JSON',
                beforeSend: function(){
                    form.find(".btn-comment").attr("disabled", true);
                    form.find('.btn-comment').html("Carregando...");
                },
                success: function(resposta){
                    if(resposta.error){
                        toastr.error(resposta.error);                   
                    }else{
                        toastr.success(resposta.success);                                            
                        form.find('input[class!="noclear"]').val('');
                        carregaComent(resposta.ocorrencia)
                        box = $('.resposta'+resposta.ocorrencia);
                        if (box.css("display") !== "none") {
                            box.slideToggle();
                        }
                    }
                },
                complete: function(resposta){                    
                    form.find(".btn-comment").attr("disabled", false);
                    form.find('.btn-comment').html("Enviar");                                
                }
            });

            return false;
        });

        function carregaComent(ocorrencia){
            $.post("{{ route('ocorrenciaCount') }}", { ocorrencia:ocorrencia }, function (response) {
                if(response.countok) {
                    $('#countComment'+response.id).html(response.countok);
                }            
            }, 'json');
        }

    });
</script>    
@stop
