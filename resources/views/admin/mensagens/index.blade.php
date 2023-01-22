@extends('adminlte::page')

@section('title', 'Painel de Controle')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Painel de Controle</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Início</a></li>
                <li class="breadcrumb-item active">Painel de Controle</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">

        @if (!empty($mensagens) && $mensagens->count() > 0)
            <div class="timeline">
                @foreach ($mensagens as $key => $msg)
                    <div class="time-label">
                        <span class="bg-gray">{{$key}}</span>
                    </div>
                    @foreach($msg as $item)
                    @php
                        if(!empty($item->colaborador->avatar) && \Illuminate\Support\Facades\Storage::exists($item->colaborador->avatar)){
                            $cover = \Illuminate\Support\Facades\Storage::url($item->colaborador->avatar);
                        } else {
                            if($item->colaborador->genero == 'masculino'){
                                $cover = url(asset('backend/assets/images/avatar5.png'));
                            }elseif($item->colaborador->genero == 'feminino'){
                                $cover = url(asset('backend/assets/images/avatar3.png'));
                            }else{
                                $cover = url(asset('backend/assets/images/image.jpg'));
                            }
                        }
                    @endphp
                    @if ($item->remetente != auth()->user()->id && $item->user == auth()->user()->id)
                        <div>                        
                            <img style="margin-left: 18px;" width="30" height="30" class="img-circle elevation-2" src="{{$cover}}" alt="{{$item->colaborador->name}}">
                            
                            <div class="timeline-item" style="{{ ($item->status == '1' ? '' : 'background-color: rgba(0,0,0,.1);')  }}">
                                <span class="time"><i class="fas fa-clock"></i> {{\Carbon\Carbon::parse($item->created_at)->format('H:i')}}</span>
                                <h3 class="timeline-header no-border">
                                    <a href="{{route('users.view-colaborador',['id' => $item->colaborador->id])}}">{{$item->colaborador->name}}</a> - {{$item->titulo}}
                                </h3>
                                <div class="timeline-body">
                                    <p class="p-1">{{$item->content}}</p>
                                    @if ($item->children)
                                        @foreach ($item->children as $subitem)
                                            <p style="background-color: rgba(0,0,0,.1);" class="ml-3 p-1">{{$subitem->content}}</p>
                                        @endforeach
                                    @endif
                                </div>
                                <form method="post" action="" autocomplete="off" class="form-horizontal j_formcomment">
                                    @csrf 
                                    <div class="input-group input-group-sm mb-0 p-2 comment{{$item->id}}">
                                        <input type="hidden" class="noclear" name="resp_id" value="{{$item->id}}" />
                                        <input type="hidden" class="noclear" name="user" value="{{$item->colaborador->id}}" />
                                        <input type="hidden" class="noclear" name="status" value="1" />
                                        <input type="hidden" class="noclear" name="remetente" value="{{auth()->user()->id}}" />
                                        <input type="hidden" class="noclear" name="titulo" value="Resp->{{$item->titulo}}" />
                                        <input class="form-control form-control-sm" name="content" placeholder="Responder Mensagem">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-success btn-comment noclear">Responder</button>
                                        </div>
                                    </div>
                                </form>
                                <div class="timeline-footer">
                                    <input type="checkbox" data-onstyle="success" data-offstyle="warning" data-size="mini" class="toggle-class" data-id="{{ $item->id }}" data-toggle="toggle" data-style="slow" data-on="<i class='fas fa-check'></i>" data-off="<i style='color:#fff !important;' class='fas fa-exclamation-triangle'></i>" {{ $item->status == true ? 'checked' : ''}}>
                                    
                                </div>
                            </div>                        
                        </div>
                    @endif
                    @endforeach
                @endforeach
            </div>
        @endif
    </div>    
</div>
@endsection

@section('footer')

    <div class="pull-right hidden-xs">
      <b>Versão</b> {{env('VERSAO_SISTEMA')}}
    </div>
    <strong>Copyright © 2005 - {{date('Y')}} <a href="https://informaticalivre.com.br">Informática Livre</a>.</strong>
  
@endsection

@section('css')
<link href="{{url(asset('backend/plugins/bootstrap-toggle/bootstrap-toggle.min.css'))}}" rel="stylesheet">
@endsection

@section('js')
<script src="{{url(asset('backend/plugins/bootstrap-toggle/bootstrap-toggle.min.js'))}}"></script>
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

        $('#toggle-two').bootstrapToggle({
            on: 'Enabled',
            off: 'Disabled'
        });

        $('.toggle-class').on('change', function() {
            var status = $(this).prop('checked') == true ? 1 : 0;
            var id = $(this).data('id');
            $.ajax({
                type: 'GET',
                dataType: 'JSON',
                url: '{{ route('msgSetStatus') }}',
                data: {
                    'status': status,
                    'id': id
                },
                success:function(data) {
                    
                }
            });
        });


        $('.j_formcomment').submit(function (){
            var form = $(this);
            var dataString = $(form).serialize();

            $.ajax({
                url: "{{ route('sendResposta') }}",
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
                        //carregaResposta(resposta.comentarioid)
                        box = $('.comment'+resposta.comentarioid);
                        if (box.css("display") !== "none") {
                            box.slideToggle();
                        }
                    }
                },
                complete: function(resposta){                    
                    form.find(".btn-comment").attr("disabled", false);
                    form.find('.btn-comment').html("Responder");                                
                }
            });

            return false;
        });

        // function carregaResposta(ocorrencia){
        //     $.post("{{ route('ocorrenciaCount') }}", { ocorrencia:ocorrencia }, function (response) {
        //         if(response.countok) {
        //             $('#countComment'+response.id).html(response.countok);
        //         }            
        //     }, 'json');
        // }

    });
</script>    
@stop