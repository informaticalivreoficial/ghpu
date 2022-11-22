@extends("web.{$configuracoes->template}.master.master")

@section('content')
<section class="banner-tems text-center">
    <div class="container">
        <div class="banner-content">
            <h2 class="h2sombra">Pré-Reserva</h2>
            <p>&nbsp;</p>
        </div>
    </div>
</section>

<!-- BODY-ROOM-5 -->
<section class="check-out">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                <div class="check-left ">                    
                    <form action="" method="post" class="j_formsubmit" autocomplete="off"> 
                    @csrf
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div id="js-contact-result"></div>
                            <!-- HONEYPOT -->
                            <input type="hidden" class="noclear" name="bairro" value="" />
                            <input type="text" class="noclear" style="display: none;" name="cidade1" value="" />
                        </div>
                    </div>
                    <div class="form_hide">  

                    <h2 style="margin-bottom: 20px;">Tipo de Hospedagem</h2>
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <input type="radio" class="check_fisica" style="width:30px;" name="tipo_reserva" value="0" checked /><span style="color: #232323;" class="check_fisica">Pessoa Física</span>
                            </div>
                        </div>  
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <input type="radio" class="check_empresa" style="width:30px;" name="tipo_reserva" value="1" /><span style="color: #232323;" class="check_empresa">Empresa</span>
                            </div>
                        </div>                                                  
                    </div>   
                    
                    <div class="div_empresa">
                        <h2 style="margin-bottom: 20px;">Dados da Empresa</h2>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Nome da Empresa </span>*</label></label>
                                    <input type="text" name="empresa_nome" class="form-control"/>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label>CNPJ <span>*</span></label>
                                    <input type="text" name="cnpj" class="form-control cnpjmask"/>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label>Telefone <span>*</span></label>
                                    <input type="text" name="telefone_empresa" class="form-control celularmask"/>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                    
                    <h2 style="margin-bottom: 20px;">Dados Pessoais</h2> 
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Nome <span>*</span></label>
                                <input type="text" name="nome" class="form-control"/>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>CPF <span>*</span></label>
                                <input type="text" name="cpf" class="form-control cpfmask"/>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>RG <span>*</span></label>
                                <input type="text" name="rg" class="form-control rgmask"/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Data de Nasc.<span>*</span></label>
                                <input type="text" name="nasc" id="nasc" class="form-control nascmask"/>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Estado</label>
                                <select name="uf" class="selectReservas" id="state-dd">
                                    @if(!empty($estados))
                                        <option value="">Selecione</option>
                                        @foreach($estados as $estado)
                                            <option value="{{$estado->estado_id}}">{{$estado->estado_nome}}</option>
                                        @endforeach                                                                        
                                    @endif                                
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-9 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Cidade</label>
                                <select id="city-dd" class="selectReservas" name="cidade">
                                    <option value="">Selecione o Estado</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-2 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>CEP </label>
                                <input type="text" name="cep" id="cep" class="form-control cepmask"/>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">                        
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Rua </label>
                                <input type="text" name="rua" class="form-control"/>
                            </div>
                        </div>
                        <div class="col-xs-9 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Bairro </label>
                                <input type="text" name="bairro" class="form-control"/>
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-2 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Número</label>
                                <input type="text" name="num" class="form-control"/>
                            </div>
                        </div>                            
                    </div>
                    <hr>
                    <h2 style="margin-bottom: 20px;">Regime de ocupação</h2>
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <input type="radio" style="width:30px;" name="ocupacao" value="1" checked />Com Café da manhã
                            </div>
                        </div>
                        
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <input type="radio" style="width:30px;" name="ocupacao" value="0" />Sem Café da manhã
                            </div>
                        </div>                                                    
                    </div>
                    <hr>
                    <h2 style="margin-bottom: 20px;">Informações de Contato</h2>
                    <div class="row">
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>E-mail <span>*</span></label>
                                <input type="text" name="email" class="form-control"/>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Telefone Móvel<span>*</span></label>
                                <input type="text" name="telefone_cliente" class="form-control celularmask"/>
                            </div>
                        </div>                        
                        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>WhatsApp </label>
                                <input type="text" name="whatsapp" class="form-control celularmask"/>
                            </div>
                        </div>                            
                    </div>
                    <hr>
                    <h2 style="margin-bottom: 20px;">Informações da Pré-reserva</h2>
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
                            <div class="check_availability-field">
                            <label>Adultos<span>*</span></label><br />
                            <select name="num_adultos" class="selectReservas">
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{$i}}" {{(!empty($dadosForm['adultos']) && $i == $dadosForm['adultos'] ? 'selected' : ($i == 1 ? 'selected' : ''))}}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                            <div class="check_availability-field">
                            <label>Crianças de 0 a 5 anos<span>*</span></label><br />
                            <select name="num_cri_0_5" class="selectReservas">
                                @for($i = 0; $i <= 5; $i++)
                                    <option value="{{$i}}" {{(!empty($dadosForm['cri_0_5']) && $i == $dadosForm['cri_0_5'] ? 'selected' : ($i == 0 ? 'selected' : ''))}}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="check_availability-field">
                                <label>Apartamento<span>*</span></label><br />
                                <select name="apart_id" class="selectReservas">
                                    @if(!empty($acomodacoes) && $acomodacoes->count() > 0)
                                        <option value="">Selecione</option>
                                        @foreach($acomodacoes as $apartamento)
                                            <option value="{{$apartamento->id}}" {{(!empty($dadosForm) && $dadosForm['apart_id'] == $apartamento->id ? 'selected' : '')}}>{{$apartamento->titulo}}</option>
                                        @endforeach                                                                        
                                    @endif                            
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-xs-6 col-sm-3 col-md-3 col-lg-4">
                            <div class="form-group">
                                <label>Check In <span>*</span></label>
                                <input type="text" data-language='pt-BR' class="form-control datepicker-here" data-date-format="dd/mm/yyyy" name="checkin" value="{{(!empty($dadosForm['checkini']) ? $dadosForm['checkini'] : '')}}" />
                            </div>
                        </div>
                        
                        <div class="col-xs-6 col-sm-3 col-md-3 col-lg-4">
                            <div class="form-group">
                                <label>Check Out <span>*</span></label>
                                <input type="text" data-language='pt-BR' class="form-control datepicker-here" data-date-format="dd/mm/yyyy" name="checkout" value="{{(!empty($dadosForm['checkouti']) ? $dadosForm['checkouti'] : '')}}" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label style="margin-bottom:3px;"><a href="javascript:;" onclick="jQuery('#modal-3').modal('show');">Política de Reservas e Hotel</a></label>
                                <button type="submit" id="js-contact-btn" class="btncheckout">Enviar Agora</button>                                    
                            </div>
                        </div>                            
                    </div>
                 </div>   
                </form>    
                </div>
                <!-- item-right -->
            </div>
            
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="check-right ">
                    {!! $paginareserva->content !!}
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
</section>
<!-- END/BODY-ROOM-5-->

<div class="modal fade custom-width" id="modal-3" aria-hidden="true" style="overflow: hidden;display: none;width:96%;">
<div class="modal-dialog" style="width: 100%;">
    <div class="modal-content" style="width: 100%;">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h4 class="modal-title">{{$politicareserva->titulo}}</h4>
            </div> 
            <div class="modal-body">
                {!! $politicareserva->content !!}
            </div>		
    </div>
</div>
</div>

@endsection

@section('css')
    <link href="{{url(asset('backend/plugins/airdatepicker/css/datepicker.min.css'))}}" rel="stylesheet" type="text/css">
@endsection

@section('js')
    <script src="{{url(asset('backend/plugins/airdatepicker/js/datepicker.min.js'))}}"></script>
    <script src="{{url(asset('backend/plugins/airdatepicker/js/i18n/datepicker.pt-BR.js'))}}"></script>
<script>
    $(document).ready(function () { 
        var $cepmask = $(".cepmask");
        $cepmask.mask('99999-999', {reverse: false});
        var $rgmask = $(".rgmask");
        $rgmask.mask('99.999.999-9', {reverse: false});
        var $cpfmask = $(".cpfmask");
        $cpfmask.mask('999.999.999-99', {reverse: false});
        var $cnpjmask = $(".cnpjmask");
        $cnpjmask.mask('99.999.999/9999-99', {reverse: false});
        var $nascmask = $(".nascmask");
        $nascmask.mask('99/99/9999', {reverse: false});
    });

    $(function(){

        // $('.datepicker-here').datepicker({
        //     autoClose: true,         
        //     minDate: new Date()
        // });

        $('.div_empresa').css("display", "none");

        $('.check_empresa').click(function() {                       
            $('.div_empresa').css("display", "block");         
            $( ".check_empresa" ).prop( "checked", true );         
            $( ".check_fisica" ).prop( "checked", false );         
        });

        $('.check_fisica').click(function() {                       
            $('.div_empresa').css("display", "none");
            $( ".check_empresa" ).prop( "checked", false );         
            $( ".check_fisica" ).prop( "checked", true );        
        });


        $("#city-dd").attr("disabled", true);
        $('#state-dd').on('change', function () {
            var idState = this.value;
            $("#city-dd").html('');
            $.ajax({
                url: "{{route('web.fetchCity')}}",
                type: "POST",
                data: {
                    estado_id: idState,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (res) {
                    $("#city-dd").attr("disabled", false);
                    $('#city-dd').html('<option value="">Selecione a cidade</option>');
                    $.each(res.cidades, function (key, value) {
                        $("#city-dd").append('<option value="' + value
                            .cidade_id + '">' + value.cidade_nome + '</option>');
                    });
                }
            });            
        });
             
    });

    $(function(){

        $('.j_formsubmit').submit(function (){
            var form = $(this);
            var dataString = $(form).serialize();

            $.ajax({
                url: "{{ route('web.acomodacaoSend') }}",
                data: dataString,
                type: 'GET',
                dataType: 'JSON',
                beforeSend: function(){
                    form.find("#js-contact-btn").attr("disabled", true);
                    form.find('#js-contact-btn').html("Carregando...");                
                    form.find('.alert').fadeOut(500, function(){
                        $(this).remove();
                    });
                },
                success: function(resposta){
                    $('html, body').animate({scrollTop:$('#js-contact-result').offset().top-130}, 'slow');
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
                    form.find("#js-contact-btn").attr("disabled", false);
                    form.find('#js-contact-btn').html('Enviar Agora');                                
                }

            });

            return false;
        });
        
    });
    
</script>   
@endsection