<!DOCTYPE html>
<html lang="pt-br">
<head>	
    <meta charset="utf-8"/>    
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
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

    <!-- FAVICON -->
    <link rel="icon" type="image/png" href="{{$configuracoes->getfaveicon()}}" />
    <link rel="shortcut icon" href="{{$configuracoes->getfaveicon()}}" type="image/x-icon"/>
    <link rel="apple-touch-icon" href="{{$configuracoes->getfaveicon()}}"/>
    <link rel="apple-touch-icon" sizes="72x72" href="{{$configuracoes->getfaveicon()}}"/>
    <link rel="apple-touch-icon" sizes="114x114" href="{{$configuracoes->getfaveicon()}}"/>

    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700,900" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900" rel="stylesheet"/>
    
    <!-- CSS LIBRARY -->
    <link rel="stylesheet" type="text/css" href="{{url('frontend/'.$configuracoes->template.'/assets/css/font-awesome.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('frontend/'.$configuracoes->template.'/assets/css/ionicons.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('frontend/'.$configuracoes->template.'/assets/css/owl.carousel.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('frontend/'.$configuracoes->template.'/assets/css/gallery.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('frontend/'.$configuracoes->template.'/assets/css/vit-gallery.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('frontend/'.$configuracoes->template.'/assets/css/bootstrap-select.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{url('frontend/'.$configuracoes->template.'/assets/css/bootstrap-datepicker.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{url('frontend/'.$configuracoes->template.'/assets/css/renato.css')}}" />
    <!-- MAIN STYLE -->
    <link rel="stylesheet" href="{{url('frontend/'.$configuracoes->template.'/assets/css/styles.css')}}"/> 
    
    <style>
        #HSystemSearchBoxInline{
            padding-top: 20px !important;
            padding-botton: 20px !important;
        }
        
    </style>
    @hasSection('css')
        @yield('css')
    @endif
 </head>
 <body>

    <!-- HEADER -->
    <header class="header-sky">
        <div class="container">
            <!--HEADER-TOP-->
            <div class="header-top">
                <div class="header-top-left"> 
                    @if ($configuracoes->email)
                        <span><i class="fa fa-envelope-o"></i> {{$configuracoes->email}}</span>
                    @endif               
                    @if ($configuracoes->whatsapp)
                        <span><img src="{{url('frontend/'.$configuracoes->template.'/assets/images/zapzap.png')}}" alt="WhatsApp" width="16" height="16" /> {{$configuracoes->whatsapp}}</span>
                    @endif 
                </div>
                <div class="header-top-right">
                    <ul>
                        <li class="dropdown"><a href="{{route('web.reservar')}}" title="Efetuar Pré-Reserva" class="dropdown-toggle">Efetuar Pré-Reserva</a></li>                    
                    </ul>
                </div>
            </div>
            <!-- END/HEADER-TOP -->
        </div>
        <!-- MENU-HEADER -->
        <div class="menu-header">
            <nav class="navbar navbar-fixed-top">
                <div class="container container-topo">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar "></span>
                            <span class="icon-bar "></span>
                            <span class="icon-bar "></span>
                        </button>
                        
                        <a class="navbar-brand" href="{{route('web.home')}}" title="{{$configuracoes->nomedosite}}">
                            <img src="{{$configuracoes->getLogomarca()}}" alt="{{$configuracoes->nomedosite}}"/>
                        </a>
                    
                        
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            @if (!empty($Links) && $Links->count())                            
                                @foreach($Links as $menuItem)                            
                                <li {{($menuItem->children && $menuItem->parent ? 'class=dropdown' : '')}}>
                                    <a {{($menuItem->target == 1 ? 'target=_blank' : '')}} href="{{($menuItem->tipo == 'Página' ? route('web.pagina', [ 'slug' => ($menuItem->post != null ? $menuItem->PostObject->slug : '#') ]) : $menuItem->url)}}" {{($menuItem->children && $menuItem->parent ? 'class=dropdown-toggle data-toggle=dropdown' : '')}}>{{ $menuItem->titulo }}{!!($menuItem->children && $menuItem->parent ? "<b class=\"caret\"></b>" : '')!!}</a>
                                    @if( $menuItem->children && $menuItem->parent)
                                    <ul class="dropdown-menu icon-fa-caret-up submenu-hover">
                                        @foreach($menuItem->children as $subMenuItem)
                                        <li><a {{($subMenuItem->target == 1 ? 'target=_blank' : '')}} href="{{($subMenuItem->tipo == 'Página' ? route('web.pagina', [ 'slug' => ($subMenuItem->post != null ? $subMenuItem->PostObject->slug : '#') ]) : $subMenuItem->url)}}">{{ $subMenuItem->titulo }}</a></li>                                        
                                        @endforeach
                                    </ul>
                                    @endif
                                </li>
                                @endforeach
                            @endif
                            <li><a href="{{route('web.atendimento')}}" title="Atendimento">Atendimento</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <!-- END / MENU-HEADER -->
    </header>
    <!-- END-HEADER -->

    <!-- INÍCIO DO CONTEÚDO DO SITE -->
    @yield('content')
    <!-- FIM DO CONTEÚDO DO SITE --> 

    <form class="btn-wats" action="{{ route('web.zapchat') }}" method="post" target="_blank">
        @csrf
        <div class="balao">
            <textarea placeholder="Digite Aqui" name="texto"></textarea>
            <button name="sendwhats" type="submit">Enviar</button>
        </div>
    </form>
        
    <div class="whatsapp-footer j_btnwhats">
        <a>
            <img src="{{url('frontend/'.$configuracoes->template.'/assets/images/zap-topo.png')}}" alt="WhatsApp" />
        </a>
    </div>
        <!-- Footer -->
        
    <!--FOOTER-->
    <footer class="footer-sky">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    @if (!empty($newsletterForm))
                        <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">
                            <div class="icon-email form_hide">                            
                                <img src="{{url('frontend/'.$configuracoes->template.'/assets/images/footer-top-icon-l.png')}}" alt="Email" class="img-responsive">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                            <div class="textbox">
                                <form class="form-inline j_submitnewsletter" action="" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <div id="js-newsletter-result"></div>
                                        <div class="form_hide">
                                            <div class="input-group">   
                                                <!-- HONEYPOT -->
                                                <input type="hidden" class="noclear" name="bairro" value="" />
                                                <input type="text" class="noclear" style="display: none;" name="cidade" value="" />
                                                <input type="hidden" class="noclear" name="status" value="1" />
                                                <input type="hidden" class="noclear" name="nome" value="#Cadastrado pelo Site" />                                 
                                                <input type="email" class="form-control" placeholder="Cadastre seu E-mail" name="email"/>
                                                <button class="btn btn-secondary" id="js-subscribe-btn"><i class="ion-android-send"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                    @if (!empty($whatsappForm))
                    <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">
                        <div class="icon-email form_hide">                            
                            <img src="{{url('frontend/'.$configuracoes->template.'/assets/images/footer-top-icon-lI.png')}}" alt="WhatsApp" class="img-responsive">                            
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                        <div class="textbox">
                            <form class="form-inline j_formsubmitwhats" action="" method="post">
                                @csrf
                                <div class="form-group">
                                    <div id="js-whats-result"></div>
                                <div class="form_hide">
                                    <div class="input-group">
                                        <!-- HONEYPOT -->
                                        <input type="hidden" class="noclear" name="bairro" value="" />
                                        <input type="text" class="noclear" style="display: none;" name="cidade" value="" />
                                        <input type="hidden" class="noclear" name="status" value="1" />
                                        <input type="text" style="width: 43%;border-right: 1px;border-right-color: #FFFFFF !important;" class="form-control" placeholder="Nome" name="nome"/>
                                        <input type="text" class="form-control celularmask" style="width: 40%;" id="zapzap" placeholder="WhatsApp" name="numero"/>
                                        <button class="btn btn-secondary"><i class="ion-android-send"></i></button>
                                    </div>
                                </div>
                                </div>
                            </form>
                        </div>
                    @endif    
                    {{--    @if ($configuracoes->facebook)
                            <a target="_blank" href="{{$configuracoes->facebook}}" title="Facebook"><i class="fa fa-facebook"></i></a>
                        @endif
                        @if ($configuracoes->twitter)
                            <a target="_blank" href="{{$configuracoes->twitter}}" title="Twitter"><i class="fa fa-twitter"></i></a>
                        @endif
                        @if ($configuracoes->instagram)
                            <a target="_blank" href="{{$configuracoes->instagram}}" title="Instagram"><i class="fa fa-instagram"></i></a>
                        @endif
                        @if ($configuracoes->linkedin)
                            <a target="_blank" href="{{$configuracoes->linkedin}}" title="linkedin"><i class="fa fa-linkedin"></i></a>
                        @endif
                        @if ($configuracoes->youtube)
                            <a target="_blank" href="{{$configuracoes->youtube}}" title="Youtube"><i class="fa fa-youtube-play"></i></a>
                        @endif     --}}                       
                    </div>
                </div>
            </div>
            <!-- /container -->
        </div>
        <!-- /footer-top -->
        <div class="footer-mid">
            <div class="container">
                <div class="row padding-footer-mid">                
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
                        <div class="footer-logo text-center list-content">
                            <a href="{{route('web.home')}}" title="Skyline">
                                <img src="{{url('frontend/'.$configuracoes->template.'/assets/images/logomarca-footer.png')}}" alt="{{$configuracoes->nomedosite}}"/>
                            </a>
                        </div>
                    </div>                    
                    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                        <div class="list-content">                    
                            <ul>                            
                            <li><a href="/pagina/galerias" title="Galerias">Galerias</a></li>
                            <li><a href="/pagina/reservar" title="Pré-Reserva">Pré-Reserva</a></li>  
                            <li><a href="/pagina/atendimento" title="Atendimento">Atendimento</a></li>                          
                            <li><a href="{{route('web.politica')}}" title="Política de Privacidade">Política de Privacidade</a></li>                          
                            </ul>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-5">
                        <div class="list-content" style="color: #fff;line-height:30px;text-align: left;">                            
                            
                            @if($configuracoes->email)
                                <i class="fa fa-envelope"></i> {{$configuracoes->email}}
                            @endif 
                            @if($configuracoes->email1)
                                <i class="fa fa-envelope"></i> {{$configuracoes->email1}}
                            @endif 
                            @if($configuracoes->rua)	
                                <br /><i class="fa fa-map-marker"></i> {{$configuracoes->rua}}
                            @if($configuracoes->num)
                                , {{$configuracoes->num}}
                            @endif
                            @if($configuracoes->bairro)
                                , {{$configuracoes->bairro}}
                            @endif
                            @if($configuracoes->cidade)  
                                - {{\App\Helpers\Cidade::getCidadeNome($configuracoes->cidade, 'cidades')}}
                            @endif
                        @endif
                        @if($configuracoes->telefone1)
                            <br /><i class="fa fa-phone"></i> {{$configuracoes->telefone1}}
                        @endif
                        @if($configuracoes->telefone2)
                            <br /><i class="fa fa-phone"></i> {{$configuracoes->telefone2}}
                        @endif
                        @if($configuracoes->telefone3)
                            <br /><i class="fa fa-phone"></i> {{$configuracoes->telefone3}}
                        @endif
                        @if($configuracoes->skype)
                            <br /><img src="{{url('frontend/'.$configuracoes->template.'/assets/images/skype.png')}}" alt="Skype" width="16" height="16" /> {{$configuracoes->skype}}
                        @endif
                        @if($configuracoes->whatsapp)
                            <br /><img src="{{url('frontend/'.$configuracoes->template.'/assets/images/zapzap.png')}}" alt="WhatsApp" width="16" height="16" /> {{$configuracoes->whatsapp}}
                        @endif                            
                        </div>
                    </div>
                    
                </div>
                <div class="footer-bottom">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 no-padding">
                        © {{$configuracoes->ano_de_inicio}} - {{date('Y')}} {{$configuracoes->nomedosite}} - Todos os direitos reservados.
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 no-padding">
                        <p class="font-accent text-right">
                            <span class="small text-silver-dark">Feito com <i style="color:red;" class="fa fa-heart"></i> por <a style="color:#fff;" target="_blank" href="{{env('DESENVOLVEDOR_URL')}}">{{env('DESENVOLVEDOR')}}</a></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- END / FOOTER-->
    
    <!--SCOLL TOP-->
    <a href="#" title="sroll" class="scrollToTop"><i class="fa fa-angle-up"></i></a>
    <!--END / SROLL TOP-->
     
    <!-- LOAD JQUERY -->
    <script src="{{url('frontend/'.$configuracoes->template.'/assets/js/jquery-1.12.4.min.js')}}"></script>
    <script src="{{url('frontend/'.$configuracoes->template.'/assets/js/owl.carousel.min.js')}}"></script>
    <script src="{{url('frontend/'.$configuracoes->template.'/assets/js/bootstrap.min.js')}}"></script>
    <script src="{{url('frontend/'.$configuracoes->template.'/assets/js/vit-gallery.js')}}"></script>
    <script src="{{url('frontend/'.$configuracoes->template.'/assets/js/jquery.countTo.js')}}"></script>
    <script src="{{url('frontend/'.$configuracoes->template.'/assets/js/jquery.appear.min.js')}}"></script>
    <script src="{{url('frontend/'.$configuracoes->template.'/assets/js/isotope.pkgd.min.js')}}"></script>
    <script src="{{url('frontend/'.$configuracoes->template.'/assets/js/bootstrap-select.js')}}"></script>
    <script src="{{url('frontend/'.$configuracoes->template.'/assets/js/jquery.littlelightbox.js')}}"></script>
    <script src="{{url('frontend/'.$configuracoes->template.'/assets/js/bootstrap-datepicker.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBDyCxHyc8z9gMA5IlipXpt0c33Ajzqix4"></script>
    <!-- Custom jQuery -->

    <script src="{{url('frontend/'.$configuracoes->template.'/assets/js/sky.js')}}"></script>

    <script src="{{url(asset('backend/assets/js/jquery.mask.js'))}}"></script>
    <script>
        $(document).ready(function () { 
            var $celularmask = $(".celularmask");
            $celularmask.mask('(99) 99999-9999', {reverse: false});            
        });
    </script>

    <script>
        $(function () {
    
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.j_btnwhats').click(function (){         
                $('.balao').slideDown();
                return false;
            });

            // Seletor, Evento/efeitos, CallBack, Ação
            $('.j_submitnewsletter').submit(function (){
                var form = $(this);
                var dataString = $(form).serialize();
    
                $.ajax({
                    url: "{{ route('web.sendNewsletter') }}",
                    data: dataString,
                    type: 'GET',
                    dataType: 'JSON',
                    beforeSend: function(){
                        form.find("#js-subscribe-btn").attr("disabled", true);
                        form.find('#js-subscribe-btn').val("Carregando...");                
                        form.find('.alert').fadeOut(500, function(){
                            $(this).remove();
                        });
                    },
                    success: function(response){
                            $('html, body').animate({scrollTop:$('#js-newsletter-result').offset().top-70}, 'slow');
                        if(response.error){
                            form.find('#js-newsletter-result').html('<div class="alert alert-danger error-msg">'+ response.error +'</div>');
                            form.find('.error-msg').fadeIn();                    
                        }else{
                            form.find('#js-newsletter-result').html('<div class="alert alert-success error-msg">'+ response.sucess +'</div>');
                            form.find('.error-msg').fadeIn();                    
                            form.find('input[class!="noclear"]').val('');
                            form.find('.form_hide').fadeOut(500);
                        }
                    },
                    complete: function(response){
                        form.find("#js-subscribe-btn").attr("disabled", false);
                        form.find('#js-subscribe-btn').val("Cadastrar");                                
                    }
    
                });
    
                return false;
            });

            $('.j_formsubmitwhats').submit(function (){
                var form = $(this);
                var dataString = $(form).serialize();
    
                $.ajax({
                    url: "{{ route('web.sendWhatsapp') }}",
                    data: dataString,
                    type: 'GET',
                    dataType: 'JSON',
                    beforeSend: function(){
                        form.find("#js-subscribe-btn").attr("disabled", true);
                        form.find('#js-subscribe-btn').val("Carregando...");                
                        form.find('.alert').fadeOut(500, function(){
                            $(this).remove();
                        });
                    },
                    success: function(response){
                            $('html, body').animate({scrollTop:$('#js-whats-result').offset().top-70}, 'slow');
                        if(response.error){
                            form.find('#js-whats-result').html('<div class="alert alert-danger error-msg">'+ response.error +'</div>');
                            form.find('.error-msg').fadeIn();                    
                        }else{
                            form.find('#js-whats-result').html('<div class="alert alert-success error-msg">'+ response.sucess +'</div>');
                            form.find('.error-msg').fadeIn();                    
                            form.find('input[class!="noclear"]').val('');
                            form.find('.form_hide').fadeOut(500);
                        }
                    },
                    complete: function(response){
                        form.find("#js-subscribe-btn").attr("disabled", false);
                        form.find('#js-subscribe-btn').val("Cadastrar");                                
                    }
    
                });
    
                return false;
            });
    
        });
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

    <script async src='https://s3-sa-east-1.amazonaws.com/hbook-universal-js/js/634efbd423248fa77bd1381f.js'></script>
    
</body>
</html>