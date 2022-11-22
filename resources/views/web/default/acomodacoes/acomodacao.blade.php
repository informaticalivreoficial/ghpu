@extends("web.{$configuracoes->template}.master.master")

@section('content')
<section class="banner-tems text-center">
    <div class="container">
        <div class="banner-content">
            <h2 class="h2sombra">{{$acomodacao->titulo}}</h2>
            <p>&nbsp;</p>
        </div>
    </div>
</section>


<!-- ROOM DETAIL -->
<section class="section-product-detail">
    <div class="container">
        
        <!-- DETAIL -->
        <div class="product-detail margin">
            <div class="row">
                <div class="col-lg-8">
                    <!-- LAGER IMGAE -->
                    <div class="wrapper">
                        <div class="">
                            <img src="{{$acomodacao->cover()}}" alt="{{$acomodacao->titulo}}" class="img-responsive"> 
                        </div>
                        <div class="content-restaurant">                            
                            <div class="row">
                                <!-- ITEM -->
                                <div class="col-md-12">
                                    <div class="restaurant_item ">
                                        <div class="row" style="margin-bottom: 20px;">
                                            @if ($acomodacao->images()->get()->count())
                                                @foreach ($acomodacao->images()->get() as $key => $image)
                                                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="margin-top: 20px;">                                                    
                                                        <div class="img">
                                                            <a data-littlelightbox-group="gallery" class="lightbox" href="{{ $image->url_image }}">
                                                                <img style="height: 111px;width:195px;" src="{{ $image->url_image }}" alt="{{$acomodacao->titulo}}" class="img-responsive"/>
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endforeach	
                                            @endif                              
                                        </div>
                                    </div>
                                </div>                                   
                            </div>
                        </div>
                    </div>
                    <!-- END / LAGER IMGAE -->
                </div>
                
                
                <div class="col-lg-4">
                    <!-- FORM BOOK -->
                    <div class="product-detail_book">
                        @if($acomodacao->exibir_valores == true)
                            <div class="product-detail_total">
                                <h6>Reserve por apenas</h6>
                                @if (!empty($acomodacao->valor_cafe))
                                    <p class="price">Valor c/ Café da Manhã<br>
                                        <span class="amout">R${{ str_replace(',00', '', $acomodacao->valor_cafe) }}</span>
                                    </p>
                                @endif
                                @if (!empty($acomodacao->valor_cafe_almoco))
                                    <p class="price">Valor c/ Café da Manhã & Almoço<br>
                                        <span class="amout">R${{ str_replace(',00', '', $acomodacao->valor_cafe_almoco) }}</span>
                                    </p>
                                @endif
                                @if (!empty($acomodacao->valor_cafe_janta))
                                    <p class="price">Valor com Café & Janta<br>
                                        <span class="amout">R${{ str_replace(',00', '', $acomodacao->valor_cafe_janta) }}</span>
                                    </p>
                                @endif
                                @if (!empty($acomodacao->valor_cri_0_5))
                                    <p class="price">Valor 0 a 5 anos<br>
                                        <span class="amout">R${{ str_replace(',00', '', $acomodacao->valor_cri_0_5) }}</span>
                                    </p>
                                @endif
                            </div>
                        @endif                       
                        
                        <div class="product-detail_form">
                            <div class="sidebar">
                                <form action="{{route('web.reservar')}}" method="post" autocomplete="off">
                                    @csrf
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">                                        
                                        <input class="noclear" type="hidden" name="apart_id" value="{{$acomodacao->id}}" />                                         
                                    </div> 
                                    <div class="widget widget_check_availability">
                                        <div class="check_availability">
                                            <div class="check_availability-field">
                                                <label>Check In</label>
                                                <div class="input-group date" data-date-format="dd/mm/yyyy" id="datepicker1">
                                                    <input class="form-control wrap-box" name="checkini" type="text"/>
                                                    <span class="input-group-addon"><i class="fa fa-calendar"  aria-hidden="true"></i></span>
                                                </div>
                                            </div>
                                            <div class="check_availability-field">
                                                <label>Check Out</label>
                                                <div id="datepicker2" class="input-group date" data-date-format="dd/mm/yyyy">
                                                    <input class="form-control wrap-box" name="checkouti" type="text"/>
                                                    <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                                </div>
                                            </div>
                                            <div class="check_availability-field">
                                                <label>Adultos</label>
                                                <select name="adultos" class="awe-select">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </div>
                                            <div class="check_availability-field">
                                                <label>Crianças 0 a 5</label>
                                                <select name="cri_0_5" class="awe-select">
                                                    <option value="0">0</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                
                                
                            </div>
                            <button type="submit" name="SendReserva" class="btn btn-room btn-product">Fazer Pré-Reserva</button>
                            </form>
                        </div>
                    </div>
                    <!-- END / FORM BOOK -->
                </div>
            </div>
        </div>
        
        <!-- TAB -->
        <div class="product-detail_tab">
            <div class="row">
                <div class="col-md-3">
                    <ul class="product-detail_tab-header">
                        <li class="active"><a href="#overview" data-toggle="tab">Descrição</a></li>                               
                    </ul>
                </div>
                <div class="col-md-9">
                    <div class="product-detail_tab-content tab-content">
                        
                        <div class="tab-pane fade active in" id="overview">
                            <div class="product-detail_overview">
                                {!!$acomodacao->descricao!!}                                    
                            </div>
                            <br />
                            <div class="row">
                                <ul>                                
                                    <div class="col-xs-6 col-lg-4"> 
                                        @if (!empty($acomodacao->ar_condicionado))
                                            <li>Ar Condicionado</li>
                                        @endif
                                        @if (!empty($acomodacao->cafe_manha))
                                            <li>Café da manhã</li>
                                        @endif
                                        @if (!empty($acomodacao->telefone))
                                            <li>Telefone</li>
                                        @endif
                                        @if (!empty($acomodacao->estacionamento))
                                            <li>Estacionamento</li>
                                        @endif
                                        @if (!empty($acomodacao->servico_quarto))
                                            <li>Serviço de Quarto</li>
                                        @endif
                                    </div>
                                    <div class="col-xs-6 col-lg-4"> 
                                        @if (!empty($acomodacao->frigobar))
                                            <li>Frigobar</li>
                                        @endif
                                        @if (!empty($acomodacao->elevador))
                                            <li>Elevador</li>
                                        @endif
                                        @if (!empty($acomodacao->vista_para_mar))
                                            <li>Vista para o Mar</li>
                                        @endif
                                        @if (!empty($acomodacao->ventilador_teto))
                                            <li>Ventilador de Teto</li>
                                        @endif
                                        @if (!empty($acomodacao->cofre_individual))
                                            <li>Cofre Individual</li>
                                        @endif
                                    </div>
                                    <div class="col-xs-6 col-lg-4">
                                        @if (!empty($acomodacao->espaco_fitness))
                                            <li>Espaço Fitness</li>
                                        @endif
                                        @if (!empty($acomodacao->wifi))
                                            <li>Wifi</li>
                                        @endif
                                        @if (!empty($acomodacao->lareira))
                                            <li>Lareira</li>
                                        @endif
                                    </div>
                                </ul>                            
                            </div>                            
                        </div>                                                 
                    </div>
                </div>
            </div>
        </div>
        <!-- END / TAB -->
        
        @if (!empty($acomodacoes) && $acomodacoes->count() > 0)
            <div class="product-detail">
                <h2 class="product-detail_title">Outras Acomodações</h2>
                <div class="product-detail_content">
                    <div class="row">
                        @foreach($acomodacoes as $aparts)
                            <div class="col-sm-6 col-md-4 col-lg-4">
                                <div class="product-detail_item">
                                    <div class="img">
                                        <a href="{{route('web.acomodacao',['slug' => $aparts->slug])}}">
                                            <img src="{{$aparts->cover()}}" alt="{{$aparts->titulo}}">
                                        </a>
                                    </div>
                                    <div class="text">
                                        <h2><a href="{{route('web.acomodacao',['slug' => $aparts->slug])}}">{{$aparts->titulo}}</a></h2>
                                        <p style="margin-top:10px;">{!!$aparts->content!!}</p>                    
                                        <a href="{{route('web.acomodacao',['slug' => $aparts->slug])}}" class="btn btn-room">+ Detalhes</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach 
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>



@endsection

@section('css')

@endsection

@section('js')

<script>
    $(function() {        

        $('#datepicker1').each(function() {
            $("#datepicker1").datepicker({
                dateFormat: 'mm/dd/yy',
                changeMonth: true,
                changeYear: true,
                yearRange: '-100y:c+nn',
                todayHighlight: true,
                startDate: "today",
                maxDate: '-1d'
            });
        });

        $('#datepicker2').each(function() {
            $("#datepicker2").datepicker({
                dateFormat: 'mm/dd/yy',
                changeMonth: true,
                changeYear: true,
                todayHighlight: true,
                startDate: "today",
                yearRange: '-100y:c+nn',
                maxDate: '-1d'
            });
        });

    });
</script>   
@endsection