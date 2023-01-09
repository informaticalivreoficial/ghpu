@extends("web.{$configuracoes->template}.master.master")

@section('content')
<section class="wrapper main-sistema">
    <div class="row" style="padding: 1%;">    
        <div class="col-md-12 shadow cem">
            <div class="row">
                <div class="col-sm-6">
                    <form action="" method="post" class="j_formsubmit" autocomplete="off">
                        @csrf
                        <div class="row" style="margin-top: 20px;">
                            <div id="js-contact-result"></div>
                        </div>
                        <div class="row form_hide">
                            <div class="col-sm-12">
                                <h3>Formulário de Suporte</h3>
                            </div>
                            <div class="col-sm-12">
                                {{-- HONEYPOT --}}
                                <input type="hidden" class="noclear" name="bairro" value="" />
                                <input type="text" class="noclear" style="display: none;" name="cidade" value="" />
                            </div>
                            <div class="col-sm-6 form-group">
                                <label><strong>Nome:</strong></label>
                                <input type="text" class="form-control input-lg" name="nome">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label><strong>E-mail:</strong></label>
                                <input type="text" class="form-control input-lg" name="email">
                            </div>
                            <div class="col-sm-12 form-group">
                                <label><strong>Assunto:</strong></label>
                                <input type="text" class="form-control input-lg" name="assunto">
                            </div>
                            
                            <div class="col-sm-12 form-group">                    
                                <textarea class="form-control input-lg" style="height:250px;" name="mensagem" placeholder="Menssagem*:"></textarea>
                            </div>

                            <div class="col-sm-12 form-group">
                                <button type="submit" style="width:100%;" class="btn btn-success btn-lg btncheckout">Enviar Agora</button>
                            </div>    
                        </div>
                    </form>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3>Informações de Contato</h3>
                        </div>
                        <div class="col-sm-12">
                            <p style="font-size: 1.2em;">
                                @if ($configuracoes->telefone1)                                
                                    <i class="fa fa-phone" aria-hidden="true"></i>
                                        <a href="tel:{{\App\Helpers\Renato::limpatelefone($configuracoes->telefone1)}}">{{$configuracoes->telefone1}}</a>
                                    <br>                                                    
                                @endif   
                                @if ($configuracoes->telefone2)
                                    <i class="fa fa-phone" aria-hidden="true"></i>
                                        <a href="tel:{{\App\Helpers\Renato::limpatelefone($configuracoes->telefone2)}}">{{$configuracoes->telefone2}}</a>
                                    <br>                        
                                @endif   
                                @if ($configuracoes->telefone3)
                                    <i class="fa fa-phone" aria-hidden="true"></i>
                                        <a href="tel:{{\App\Helpers\Renato::limpatelefone($configuracoes->telefone3)}}">{{$configuracoes->telefone3}}</a>
                                    <br>                       
                                @endif
                                @if ($configuracoes->whatsapp)
                                    <strong>WhatsApp:</strong>
                                        <a href="{{\App\Helpers\WhatsApp::getNumZap($configuracoes->whatsapp ,'Atendimento '.$configuracoes->nomedosite)}}">{{$configuracoes->whatsapp}}</a>
                                    <br>                        
                                @endif
                            </p>                        
                            <p>
                                @if ($configuracoes->email)
                                    <i class="fa fa-envelope-o"></i> <a href="mailto:{{$configuracoes->email}}">{{$configuracoes->email}}</a><br>
                                @endif
                                @if ($configuracoes->email1)
                                    <i class="fa fa-envelope-o"></i> <a href="mailto:{{$configuracoes->email1}}">{{$configuracoes->email1}}</a><br>
                                @endif
                            </p>                        
                            <p>
                                @if($configuracoes->rua)	
                                        {{$configuracoes->rua}}
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
                            </p>                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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