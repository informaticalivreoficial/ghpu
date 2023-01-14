@extends('adminlte::page')

@section('title', 'Gerenciar Clientes')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1><i class="fas fa-user mr-2"></i> Perfil</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Painel de Controle</a></li>
            <li class="breadcrumb-item"><a href="{{route('users.index')}}">Colaboradores</a></li>
            <li class="breadcrumb-item active">Perfil</li>
        </ol>
    </div>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-md-3">

        <div class="card card-teal card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    @php
                        if(!empty($user->avatar) && \Illuminate\Support\Facades\Storage::exists($user->avatar)){
                            $cover = \Illuminate\Support\Facades\Storage::url($user->avatar);
                        } else {
                            if($user->genero == 'masculino'){
                                $cover = url(asset('backend/assets/images/avatar5.png'));
                            }elseif($user->genero == 'feminino'){
                                $cover = url(asset('backend/assets/images/avatar3.png'));
                            }else{
                                $cover = url(asset('backend/assets/images/image.jpg'));
                            }
                        }
                    @endphp
                    <img class="profile-user-img img-fluid img-circle" src="{{$cover}}" alt="{{$user->name}}">
                </div>

                <h3 class="profile-username text-center">{{$user->name}}</h3>
                <p class="text-muted text-center">{{$user->funcao}}</p>

                @if ($user->email)
                    <p class="text-muted text-center"><b>Email</b><br>{{$user->email}}</p>
                @endif
                @if ($user->celular)
                    <p class="text-muted text-center"><b>Telefone</b><br>{{$user->celular}}</p>
                @endif
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Ocorrências</b> <a class="float-right">{{$user->countOcorrencia() ?? '0'}}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Último acesso:</b> <a class="float-right">{{\Carbon\Carbon::parse($user->last_login_at)->format('d/m - H:i')}}</a>
                    </li>
                    {{--<li class="list-group-item">
                        <b>Following</b> <a class="float-right">543</a>
                    </li>
                    <li class="list-group-item">
                        <b>Friends</b> <a class="float-right">13,287</a>
                    </li>--}}
                </ul>
            </div>
        </div>      
    </div>
    <!-- /.col -->
    <div class="col-md-9">
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Enviar Mensagem</a></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content"> 
                    <div class="tab-pane active" id="settings">
                        <form action="" method="POST" class="form-horizontal j_formsubmit" autocomplete="off">
                            @csrf
                            <div class="form-group row form_hide">
                                <label for="inputSkills" class="col-sm-2 col-form-label">Assunto</label>
                                <div class="col-sm-10">
                                    <input type="hidden" class="noclear" name="user" value="{{$user->id}}">
                                    <input type="hidden" class="noclear" name="remetente" value="{{auth()->user()->id}}">
                                    <input type="hidden" class="noclear" name="status" value="1">
                                    <input type="text" class="form-control" name="titulo" id="inputSkills" placeholder="Assunto">
                                </div>
                            </div>
                            <div class="form-group row form_hide">
                                <label for="inputExperience" class="col-sm-2 col-form-label">Mensagem</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="content" id="inputExperience" placeholder="Mensagem"></textarea>
                                </div>
                            </div> 
                            <div class="form-group row form_hide">
                                <div class="offset-sm-2 col-sm-10">
                                    <button type="submit" class="btn btn-success btncheckout noclear">Enviar Mensagem</button>
                                </div>
                            </div>
                        </form>
                    </div>    
                </div>    
            </div>
        </div>

        <div class="card">          
            <div class="card-body">
                <h5 class="text-bold">Informações Pessoais</h5>
                <div class="row mt-3 text-muted">
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4">
                        <p><b>CPF:</b> {{$user->cpf}}</p>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4">
                        <p><b>RG:</b> {{$user->rg}}</p>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4">
                        <p><b>RG/Expedição:</b> {{$user->rg_expedicao}}</p>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4">
                        <p><b>Data de Nascimento:</b> {{$user->nasc}}</p>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4">
                        <p><b>Naturalidade:</b> {{$user->naturalidade}}</p>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4">
                        <p><b>Estado Civil:</b> {{$user->estado_civil}}</p>
                    </div>
                </div>
                <hr>
                <h5 class="text-bold">Informações de Contato</h5>
                <div class="row mt-3 text-muted">
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4">
                        <p><b>telefone:</b> {{$user->telefone}}</p>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4">
                        <p><b>Celular:</b> {{$user->celular}}</p>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4">
                        <p><b>WhatsApp:</b> {{$user->whatsapp}}</p>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                        <p><b>Skype:</b> {{$user->skype}}</p>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-5">
                        <p><b>Email:</b> {{$user->email}}</p>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4">
                        <p><b>Email 1:</b> {{$user->email1}}</p>
                    </div>                  
                </div>              
                <hr>
                <h5 class="text-bold">Endereço</h5>
                <div class="row mt-3 text-muted">
                    <div class="col-md-6">
                        <p><b>Endereço:</b> {{$user->rua}}</p>
                    </div>
                    <div class="col-md-3">
                        <p><b>Número:</b> {{$user->num}}</p>
                    </div>
                    <div class="col-md-3">
                        <p><b>Cep:</b> {{$user->cep}}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.col -->
  </div>
@stop

@section('js')
<script>
    $(function () {

        $('.j_formsubmit').submit(function (){
            var form = $(this);
            var dataString = $(form).serialize();

            $.ajax({
                url: "{{ route('sendUserMsg') }}",
                data: dataString,
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function(){
                    form.find(".btncheckout").attr("disabled", true);
                    form.find('.btncheckout').html("Carregando..."); 
                },
                success: function(resposta){
                    if(resposta.error){
                        toastr.error(resposta.error);                                            
                    }else{
                        toastr.success(resposta.sucess);                   
                        form.find('input[class!="noclear"]').val('');
                        form.find('textarea[class!="noclear"]').val('');
                        //form.find('.form_hide').fadeOut(500);
                    }
                },
                complete: function(resposta){
                    form.find(".btncheckout").attr("disabled", false);
                    form.find('.btncheckout').html("Enviar Mensagem");                                
                }
            });

            return false;
        });

    });
</script>
@endsection