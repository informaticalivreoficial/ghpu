@extends("web.{$configuracoes->template}.master.master")

@section('content')
<section class="banner-tems text-center">
    <div class="container">
        <div class="banner-content">
            <h2 class="h2sombra">Atendimento</h2>
        </div>
    </div>
</section>

<section class="section-contact">
    <div class="container">
        <div class="contact">
            <div class="row">
                <div class="col-md-6 col-lg-5">
                    <div class="text">                            
                        <p></p>
                        <ul>
                            <li>
                                @if($configuracoes->rua)	
                                        <i class=" fa ion-ios-location-outline"></i> {{$configuracoes->rua}}
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
                            </li>

                            @if ($configuracoes->telefone1)                                
                                <li><i class="fa fa-phone" aria-hidden="true"></i>
                                    <a href="tel:{{\App\Helpers\Renato::limpatelefone($configuracoes->telefone1)}}">{{$configuracoes->telefone1}}</a>
                                </li>                                                    
                            @endif   
                            @if ($configuracoes->telefone2)
                                <li><i class="fa fa-phone" aria-hidden="true"></i>
                                    <a href="tel:{{\App\Helpers\Renato::limpatelefone($configuracoes->telefone2)}}">{{$configuracoes->telefone2}}</a>
                                </li>                        
                            @endif   
                            @if ($configuracoes->telefone3)
                                <li><i class="fa fa-phone" aria-hidden="true"></i>
                                    <a href="tel:{{\App\Helpers\Renato::limpatelefone($configuracoes->telefone3)}}">{{$configuracoes->telefone3}}</a>
                                </li>                        
                            @endif   
                            @if ($configuracoes->whatsapp)
                                <li>
                                    <a href="{{\App\Helpers\WhatsApp::getNumZap($configuracoes->whatsapp ,'Atendimento '.$configuracoes->nomedosite)}}">WhatsApp: {{$configuracoes->whatsapp}}</a>
                                </li>                        
                            @endif                         
                        </ul>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-6 col-lg-offset-1">
                    <div class="contact-form">
                        <form method="post" action="" class="j_formsubmit" autocomplete="off">  
                            @csrf                          
                            <div class="row">                                
                                <div class="col-sm-12">
                                    <div id="js-contact-result"></div>
                                </div>
                                <div class="form_hide">
                                    <div class="col-sm-6">
                                        <!-- HONEYPOT -->
                                        <input type="hidden" class="noclear" name="bairro" value="" />
                                        <input type="text" class="noclear" style="display: none;" name="cidade" value="" />
                                        <input type="text" class="field-text" placeholder="Seu Nome" name="nome"/>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="field-text" placeholder="Seu E-mail" name="email"/>
                                    </div>                                        
                                    <div class="col-sm-12">
                                        <textarea cols="30" rows="10" placeholder="Mensagem" name="mensagem" class="field-textarea"></textarea>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-room btncheckout">Enviar Agora</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END / CONTACT -->

<div class="section-map">
    {!!$configuracoes->mapa_google!!}
</div>

@endsection

@section('js')
<script>
    $(function () {

        // Seletor, Evento/efeitos, CallBack, Ação
        $('.j_formsubmit').submit(function (){
            var form = $(this);
            var dataString = $(form).serialize();

            $.ajax({
                url: "{{ route('web.sendEmail') }}",
                data: dataString,
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function(){
                    form.find(".btncheckout").attr("disabled", true);
                    form.find('.btncheckout').html("Carregando...");                
                    form.find('.alert').fadeOut(500, function(){
                        $(this).remove();
                    });
                },
                success: function(resposta){
                    $('html, body').animate({scrollTop:$('#js-contact-result').offset().top-100}, 'slow');
                    if(resposta.error){
                        form.find('#js-contact-result').html('<div class="alert alert-danger error-msg">'+ resposta.error +'</div>');
                        form.find('.error-msg').fadeIn();                    
                    }else{
                        form.find('#js-contact-result').html('<div class="alert alert-success error-msg">'+ resposta.sucess +'</div>');
                        form.find('.error-msg').fadeIn();                    
                        form.find('input[class!="noclear"]').val('');
                        form.find('textarea[class!="noclear"]').val('');
                        form.find('.form_hide').fadeOut(500);
                    }
                },
                complete: function(resposta){
                    form.find(".btncheckout").attr("disabled", false);
                    form.find('.btncheckout').html("Enviar Agora");                                
                }
            });

            return false;
        });

    });
</script>   
@endsection