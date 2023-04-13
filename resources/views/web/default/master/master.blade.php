<!DOCTYPE html>
<html lang="pt-br">
<head>	
    <meta charset="utf-8"/>    
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="language" content="pt-br" /> 
    <meta name="author" content="{{env('DESENVOLVEDOR')}}"/>
    <meta name="designer" content="Renato Montanari">
    <meta name="publisher" content="Renato Montanari">
    <meta name="url" content="{{$configuracoes->dominio}}" />
    <meta name="keywords" content="{{$configuracoes->metatags}}">
    <meta name="distribution" content="web">
    <meta name="rating" content="general">
    <meta name="date" content="Dec 26">

    {!! $head ?? '' !!}

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{url('frontend/'.$configuracoes->template.'/assets/css/style.css')}}"/>
    <link rel="stylesheet" href="{{url('frontend/'.$configuracoes->template.'/assets/css/bootstrap.css')}}"/>
    <link rel="stylesheet" href="{{url('frontend/'.$configuracoes->template.'/assets/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{url('frontend/'.$configuracoes->template.'/assets/css/bootstrap-reset.css')}}"/>

    <link rel="stylesheet" href="{{url('frontend/'.$configuracoes->template.'/assets/css/table-responsive.css')}}"/>
    <link rel="stylesheet" href="{{url('frontend/'.$configuracoes->template.'/assets/css/jquery-ui-1.10.3.css')}}"/>

    <!--file upload-->
    <link rel="stylesheet" href="{{url('frontend/'.$configuracoes->template.'/assets/css/bootstrap-fileupload.min.css')}}" />

    <!--pickers css-->
    <link rel="stylesheet" href="{{url('frontend/'.$configuracoes->template.'/assets/js/bootstrap-datepicker/css/datepicker-custom.css')}}" />

    <link rel="stylesheet" href="{{url('frontend/'.$configuracoes->template.'/assets/css/renato.css')}}"/>
    <link rel="stylesheet" href="{{url('frontend/'.$configuracoes->template.'/assets/css/style-responsive.css')}}"/>
    <!-- Fontes -->
    <link href="{{url('frontend/'.$configuracoes->template.'/assets/fonts/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic" rel="stylesheet"/>

    <!-- Toastr -->
   <link rel="stylesheet" href="{{url(asset('backend/plugins/toastr/toastr.min.css'))}}">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="{{url('frontend/'.$configuracoes->template.'/assets/js/html5shiv.js')}}"></script>
        <script src="{{url('frontend/'.$configuracoes->template.'/assets/js/respond.min.js')}}"></script>
    <![endif]-->

    <!-- Favicon Icon -->
    <link rel="icon"  type="image/png" href="{{$configuracoes->getfaveicon()}}"/>

    <style>
        .toast {
            top: 60px;
        }
    </style>

    @hasSection('css')
        @yield('css')
    @endif
 </head>
 <body>
    {{--MODAL DE CARREGAMENTO DO SISTEMA--}}
    <div class="dialog">
        <div class="loadsistem">
            <img src="{{url('frontend/'.$configuracoes->template.'/assets/images/loading.gif')}}" width="36" height="35" alt="Carregando" title="Carregando" />
        </div>
    </div>

    <header>
        <section class="wrapper header-login">    
            <div class="row">
                    <div class="col-sm-4">
                        <div class="telefone-topo">
                            @if($configuracoes->telefone1)
                                <p class="fone-topo"><i class="fa fa-phone"></i> &nbsp;{{$configuracoes->telefone1}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-8 login-sistema">
                        @if (Route::has('login'))
                            <div class="login-colaboradores">                        
                                @auth
                                    <p class="boas-vindas">
                                        Olá {{\App\Helpers\Renato::getPrimeiroNome(auth()->user()->name)}}! &nbsp;
                                        &nbsp; <a href="{{route('logout')}}">Sair&nbsp; <i class="fa fa-power-off"></i></a>
                                    </p>
                                @else
                                    <form method="post" action="{{ route('login.do') }}" class="form-inline" autocomplete="off" name="login">
                                        <div class="form-group">
                                            <label for="" class="control-label">Colaboradores:</label>
                                            <input type="text" class="form-control input-lg" name="rg" value="" data-mask="99.999.999-9"/>
                                            <button class="btn btn-success btn-lg" type="submit" name="sendLogar">Entrar</button>
                                        </div>                                
                                    </form>
                                @endauth                
                            </div>                            
                        @endif                            
                    </div>
                </div>
        </section>
        <section class="wrapper header-logo">
            <div class="row">
                <div class="col-sm-3">    
                    <div class="main-header-logo">
                        <a href="{{route('web.home')}}">
                            <img src="{{$configuracoes->getLogomarca()}}" alt="{{$configuracoes->nomedosite}}"/>
                        </a>
                    </div>                
                </div>                
                <div class="col-sm-9">        
                    <div class="main-header-menu">   
                        <div class="mobile_action"></div>             
                        <ul class="main_header_nav">
                            <li class="main_header_nav_item"><a href="{{route('web.home')}}">Início</a></li>
                            <li class="main_header_nav_item"><a href="{{route('web.atendimento')}}">Suporte</a></li>
                            @if (Route::has('login'))
                                @auth
                                <li class="main_header_nav_item"><a href="#">Minha Conta</a>
                                    <ul class="main_header_nav_sub">
                                        <li class="main_header_nav_sub_item"><a href="{{route('users.edit',['id' => auth()->user()->id])}}">Editar perfil</a></li>
                                        <li class="main_header_nav_sub_item"><a href="{{route('home')}}">Ocorrências</a></li>
                                    </ul>                        
                                </li>
                                @endauth
                            @endif
                        </ul>                
                    </div>                
                </div>
            </div>
        </section>
    </header>

    {{-- INÍCIO DO CONTEÚDO DO SITE --}}
    @yield('content')
    {{-- FIM DO CONTEÚDO DO SITE --}} 

    <footer>
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-md-12">
                    
                    @if(!empty($boletim))
                        <div class="row">
                            <div class="col-12">
                                <h3>Previsão do tempo Atualização: <span>{{ Carbon\Carbon::now()->format('d/m/Y') }}</span></h3>    
                            </div>   
                            @foreach ($boletim as $item)
                            
                                <div class="col-sm-12 col-md-3">                       
                                    <p style="text-align: center;padding-bottom:10px;margin-bottom: 10px;border-bottom: 3px solid #e9eaea;">
                                        <img src="{{url(asset('backend/assets/images/'.$item['img']))}}" alt="" title=""/><br>
                                        <b>{{$item['data']}}</b><br>
                                        <b>{{$item['previsao']}}</b><br>                                           
                                        <b>Mínima:</b> {{$item['minima']}}&deg;<br>   
                                        <b>Mínima:</b> {{$item['maxima']}}&deg;<br> 
                                        <b>Índice UV:</b> <span style="padding:5px;{{$item['iuvcolor']}}">{{$item['iuv']}}</span><br>  
                                    </p>                                   
                                </div>
                            @endforeach 
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <p class="footerP">Copyright&copy; {{$configuracoes->ano_de_inicio}} - {{date('Y')}} {{$configuracoes->nomedosite}} - Todos os direitos reservados.</p>
        <p class="font-accent text-center">
            <span class="small text-silver-dark">Feito com <i style="color:red;" class="fa fa-heart"></i> por <a target="_blank" href="{{env('DESENVOLVEDOR_URL')}}">{{env('DESENVOLVEDOR')}}</a></span>
        </p>
    </footer>
        
    <script src="{{url('frontend/'.$configuracoes->template.'/assets/js/jquery-1.10.2.min.js')}}"></script>
    <script src="{{url('frontend/'.$configuracoes->template.'/assets/js/jquery-ui-1.9.2.custom.min.js')}}"></script>
    <script src="{{url('frontend/'.$configuracoes->template.'/assets/js/jquery-migrate-1.2.1.min.js')}}"></script>
    <script src="{{url('frontend/'.$configuracoes->template.'/assets/js/bootstrap.min.js')}}"></script>
    <script src="{{url('frontend/'.$configuracoes->template.'/assets/js/modernizr.min.js')}}"></script>

    <!--file upload-->
    <script src="{{url('frontend/'.$configuracoes->template.'/assets/js/bootstrap-fileupload.min.js')}}"></script>

    <!-- Input Mask -->
    <script src="{{url('frontend/'.$configuracoes->template.'/assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js')}}"></script>

    <!-- CK Editor -->
    <script src="{{url('frontend/'.$configuracoes->template.'/assets/js/ckeditor/ckeditor.js')}}"></script>
    <script src="{{url('frontend/'.$configuracoes->template.'/assets/js/ckeditor/adapters/jquery.js')}}"></script>
    <script type="text/javascript">
        var editor = CKEDITOR.replaceAll( 'editor', {});
    </script>
    <!-- CK Editor -->

    <script src="{{url('frontend/'.$configuracoes->template.'/assets/js/datetime/jquery.datetimepicker.full.min.js')}}"></script>
    <link rel="stylesheet" href="{{url('frontend/'.$configuracoes->template.'/assets/js/datetime/jquery.datetimepicker.css')}}"/>

    <!--pickers plugins-->
    <script src="{{url('frontend/'.$configuracoes->template.'/assets/js/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>

    <!--pickers initialization-->
    <script src="{{url('frontend/'.$configuracoes->template.'/assets/js/pickers-init.js')}}"></script>

    <script src="{{url('frontend/'.$configuracoes->template.'/assets/js/scripts.js')}}"></script>

    <!--jquery form-->
    <script src="{{url('frontend/'.$configuracoes->template.'/assets/js/jquery.form.js')}}"></script>

    <!-- Toastr -->
    <script src="{{url(asset('backend/plugins/toastr/toastr.min.js'))}}"></script>

    <script>
        $(function () {
    
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('form[name="login"]').submit(function (event) {
                event.preventDefault();

                const form = $(this);
                const action = form.attr('action');
                const rg = form.find('input[name="rg"]').val();

                $.post(action, {rg:rg}, function (response) {

                    if(response.message) {
                        toastr.error(response.message);
                    }

                    if(response.redirect) {
                        toastr.success(response.msg);
                        setTimeout(function() {
                            window.location.href = response.redirect;
                        }, 2000);                                
                    }
                }, 'json');

            });
    
        });
    </script>

    <script type="text/javascript">
        (function ($) {
            
        
            $('.j_loadstate').change(function() {
                var uf = $('.j_loadstate');
                var city = $('.j_loadcity');
                var patch = basesite + 'ajax/cidades.php';
        
                city.attr('disabled', 'true');
                uf.attr('disabled', 'true');
        
                city.html('<option value=""> Carregando cidades... </option>');
        
                $.post(patch, {estado: $(this).val()}, function(cityes) {
                    city.html(cityes).removeAttr('disabled');
                    uf.removeAttr('disabled');
                });
            });
        
            //CONTROLE DO MENU MOBILE
            $('.mobile_action').click(function () {
                if (!$(this).hasClass('active')) {
                    $(this).addClass('active');
                    $('.main_header_nav').animate({'left': '0px'}, 300);
                } else {
                    $(this).removeClass('active');
                    $('.main_header_nav').animate({'left': '-100%'}, 300);
                }
            });
        
            // FUNÇÃO MODAL DE CARREGAMENTO DO SISTEMA
            $(window).ready(function(){
                $('.loadsistem').fadeOut("fast",function(){
                    $('.dialog').fadeOut("fast");
                });
            });
        
            // DESABILIDA TEXTAREA DA OCORRENCIA
            //$('.editor').attr("disabled", true);
        
            // SELECIONA O MODELO DA OCORRENCIA
            $(document).ready(function() {
                $('.modelo').change(function(){
                    $('.finish').attr("disabled", true);
                    $('.finish').html("Carregando...");
                    var id_modelo = $('#modelo option:selected').val();
                    $('.loadModelo').load(basesite + '/ajax/ajax-modelos.php?modelo=' + id_modelo, function(){
                        $('.finish').removeAttr("disabled");
                        $('.finish').html("Publicar Agora");
                    });
                });
            });
            // $('.modelo').change(function(){
            //
            //     $('.loadModelo').load(basesite + '/ajax/ajax-modelos.php?modelo=' + id_modelo);
            //     $('.finish').html("Publicar Agora");
            // });
        
            // FORM DE SUPORTE
            $('.j_suporteSend').submit(function (){
                var form = $(this);
                var data = $(this).serialize();
        
                $.ajax({
                    url: ajaxbase,
                    data: data,
                    type: 'POST',
                    dataType: 'json',
        
                    beforeSend: function(){
                        form.find('.b_nome').html("Carregando...");
                        form.find('.alert').fadeOut(500, function(){
                            $(this).remove();
                        });
                    },
                    success: function(resposta){
                        //console.clear();
                        //console.log(resposta);
                        $('html, body').animate({scrollTop:0}, 'slow');
                        if(resposta.error){
                            form.find('.alertas').html('<div class="alert alert-danger">'+ resposta.error +'</div>');
                            form.find('.alert-danger').fadeIn();
                        }else{
                            form.find('.alertas').html('<div class="alert alert-success">'+ resposta.sucess +'</div>');
                            form.find('.alert-success').fadeIn();
                            //form.find('input[class!="noclear"]').val('');
                            //form.find('textarea[class!="noclear"]').val('');
                            form.find('.form_hide').fadeOut(500);
                        }
                    },
                    complete: function(resposta){
                        form.find('.b_nome').html("Enviar Agora");
                    }
                });
                return false;
            });
        
        
            $('.j_submitocorrencia').submit(function (){
                var dadosajax = {
                    'action' : $("#action").val(),
                    'data' : $("#data").val(),
                    'colaborador_id' : $("#colaborador_id").val(),
                    'content' : CKEDITOR.instances["content"].getData(),
                    'hotel_id' : $("#hotel_id").val(),
                    'modelo_id' : $("#modelo").val(),
                    'status' : $("#status").val(),
                    'titulo' : $("#titulo").val()
                };
                //var form = $(this);
                //var data = $(this).serialize();
                $.ajax({
                    url: ajaxbase,
                    data: dadosajax,
                    type: 'POST',
                    dataType: 'json',
        
                    beforeSend: function(){
                        $('.finish').html("Carregando...");
                        $('.alert').fadeOut(500, function(){
                            $(this).remove();
                        });
                    },
                    success: function(resposta){
                        $('html, body').animate({scrollTop:$('.alertas').offset().top-135}, 'slow');
                        if(resposta.error){
                            $('.alertas').html('<div class="alert alert-danger">'+ resposta.error +'</div>');
                            $('.alert-danger').fadeIn();
                        }else{
                            $('.alertas').html('<div class="alert alert-success">'+ resposta.sucess +'</div>');
                            $('.alert-sucess').fadeIn();
                            //form.find('input[class!="noclear"]').val('');
                            $('.form_hide').fadeOut(500);
                        }
                    },
                    complete: function(resposta){
                        $('.finish').html("Publicar Agora");
                    }
                });
                return false;
            });
        
            $('.j_submitocorrenciaEdit').submit(function (){
                var dadosajax = {
                    'action' : $("#action").val(),
                    'colaborador_id' : $("#colaborador_id").val(),
                    'content' : CKEDITOR.instances["content"].getData(),
                    'hotel_id' : $("#hotel_id").val(),
                    'status' : $("#status").val(),
                    'titulo' : $("#titulo").val(),
                    'uppdate' : $("#uppdate").val(),
                    'id' : $("#id").val()
                };
                //var form = $(this);
                //var data = $(this).serialize();
                $.ajax({
                    url: ajaxbase,
                    data: dadosajax,
                    type: 'POST',
                    dataType: 'json',
        
                    beforeSend: function(){
                        $('.finish').html("Carregando...");
                        $('.alert').fadeOut(500, function(){
                            $(this).remove();
                        });
                    },
                    success: function(resposta){
                        $('html, body').animate({scrollTop:$('.alertas').offset().top-135}, 'slow');
                        if(resposta.error){
                            $('.alertas').html('<div class="alert alert-danger">'+ resposta.error +'</div>');
                            $('.alert-danger').fadeIn();
                        }else{
                            $('.alertas').html('<div class="alert alert-success">'+ resposta.sucess +'</div>');
                            $('.alert-sucess').fadeIn();
                            //form.find('input[class!="noclear"]').val('');
                            //form.find('.form_hide').fadeOut(500);
                        }
                    },
                    complete: function(resposta){
                        $('.finish').html("Atualizar Agora");
                    }
                });
                return false;
            });
        
            $('.j_submitocolaboradorEdit').submit(function (){
                var form = $(this);
                var data = $(this).serialize();
                $.ajax({
                    url: ajaxbase,
                    data: data,
                    type: 'POST',
                    dataType: 'json',
        
                    beforeSend: function(){
                        form.find('.finish').html("Carregando...");
                        form.find('.alert').fadeOut(500, function(){
                            $(this).remove();
                        });
                    },
                    success: function(resposta){
                        $('html, body').animate({scrollTop:$('.alertas').offset().top-135}, 'slow');
                        if(resposta.error){
                            form.find('.alertas').html('<div class="alert alert-danger">'+ resposta.error +'</div>');
                            form.find('.alert-danger').fadeIn();
                        }else{
                            form.find('.alertas').html('<div class="alert alert-success">'+ resposta.sucess +'</div>');
                            form.find('.alert-sucess').fadeIn();
                            //form.find('input[class!="noclear"]').val('');
                            //form.find('.form_hide').fadeOut(500);
                        }
                    },
                    complete: function(resposta){
                        form.find('.finish').html("Atualizar");
                    }
                });
                return false;
            });
        
            // DATETIMEPICKER
            $.datetimepicker.setLocale('pt-BR');
        
            $('.datetimepicker').datetimepicker({
                format:	'd/m/Y H:i',
                dayOfWeekStart : 1,
                lang:'pt-BR',
                //disabledDates:['1986/01/08','1986/01/09','1986/01/10']
            });
            $('.datetimepicker').datetimepicker({step:30});
        
            $('.some_class').datetimepicker();
        
            // UPLOAD DO AVATAR
            var formFiles, divReturn, progressBar;
            formFiles = document.getElementById('formFiles');
            divReturn = document.getElementById('alertas');
            progressBar = document.getElementById('progressBar');
        
            formFiles.addEventListener('submit', sendForm, false);
            function sendForm(evt){
                var formData, ajax, pct;
                var bar = $('.progress');
        
                formData = new FormData(evt.target);
                ajax = new XMLHttpRequest();
        
                ajax.onreadystatechange = function () {
                    if(ajax.readyState == 4){
                        formFiles.reset();
                        divReturn.textContent = ajax.response;
                        progressBar.style.display = 'none';
                        bar.fadeOut("slow");
                        $('.finish').text('Enviar Foto').fadeIn("fast");
                        $('#alertas').empty().html('<div class="alert alert-success"><strong>Sucesso!</strong> Foto enviada corretamente.</div>').fadeIn("fast");
                        window.location.reload(true);
                    }else{
                        progressBar.style.display = 'block';
                        divReturn.style.display = 'block';
                        divReturn.textContent = 'Enviando Foto!';
                        $('.finish').text('Carregando...').fadeIn("fast");
                    }
                }
        
                ajax.upload.addEventListener('progress', function (evt){
                    pct = Math.floor((evt.loaded * 100) / evt.total);
                    progressBar.style.width = pct + '%';
                    progressBar.getElementsByTagName('span')['0'].textContent = pct + '%';
                }, false);
        
                ajax.open('POST', basesite + 'ajax/ajax-upload.php');
                ajax.send(formData);
            }
        
        })(jQuery);
        </script>


    

    @hasSection('js')
        @yield('js')
    @endif    

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{$configuracoes->tagmanager_id}}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
    
        gtag('config', '{{$configuracoes->tagmanager_id}}');
    </script>

</body>
</html>