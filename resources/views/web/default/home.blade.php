@extends("web.{$configuracoes->template}.master.master")

@section('content')
    <section class="wrapper main-sistema">
        <div class="row empresas-logo">
            @if (!empty($empresas) && $empresas->count() > 0)
                @foreach($empresas as $empresa)
                    <div class="col-xs-6 col-md-3 empresas-logo-logo">
                        <a href="{{$empresa->link}}" title="{{$empresa->titulo}}">
                        <img alt="{{$empresa->titulo}}" src="{{$empresa->cover()}}"/>
                        </a>
                    </div>
                @endforeach
            @endif

            <div class="col-xs-12 col-md-6 cotacao">
                <h3>Cotações</h3>
                @php
                    // PEGA COTAÇÃO VIA JSON
                    $url = @file_get_contents('https://economia.awesomeapi.com.br/json/USD-BRL/1');
                    if ($url !== false && !empty($url)) {
                        $json = json_decode($url, true);
                        $imprime = end($json);
                        $cor = ($imprime['pctChange'] < '0' ? 'pos' :
                            ($imprime['pctChange'] == '0' ? 'neutro' : 
                            ($imprime['pctChange'] > '0' ? 'neg' : 'neg')));
                        $sinal = ($imprime['pctChange'] < '0' ? '' :
                            ($imprime['pctChange'] == '0' ? '' : 
                            ($imprime['pctChange'] > '0' ? '+' : '+')));
                        echo '<div class="numbers">';                    
                        echo '<span class="value bra"> '.$imprime['name'].' R$'.number_format($imprime['ask'],'3',',','').'</span>';
                        echo ' <span class="data '.$cor.'">'.$sinal.' '.number_format($imprime['pctChange'],'2',',','').'% </span>';
                        echo '</div>';
                    }							
                    $urlEuro = @file_get_contents('https://economia.awesomeapi.com.br/json/EUR-BRL/1');
                    if ($urlEuro !== false && !empty($urlEuro)) {
                        $json = json_decode($urlEuro, true);
                        $imprime = end($json);
                        $cor = ($imprime['pctChange'] < '0' ? 'pos' :
                            ($imprime['pctChange'] == '0' ? 'neutro' : 
                            ($imprime['pctChange'] > '0' ? 'neg' : 'neg')));
                        $sinal = ($imprime['pctChange'] < '0' ? '' :
                            ($imprime['pctChange'] == '0' ? '' : 
                            ($imprime['pctChange'] > '0' ? '+' : '+')));
                        echo '<div class="numbers">';                    
                        echo '<span class="value bra"> '.$imprime['name'].' R$'.number_format($imprime['ask'],'3',',','').'</span>';
                        echo ' <span class="data '.$cor.'">'.$sinal.' '.number_format($imprime['pctChange'],'2',',','').'% </span>';
                        echo '</div>';
                    }							
                    $urlBTC = @file_get_contents('https://economia.awesomeapi.com.br/json/BTC-BRL/1');
                    if ($urlBTC !== false && !empty($urlBTC)) {
                        $json = json_decode($urlBTC, true);
                        $imprime = end($json);
                        $cor = ($imprime['pctChange'] < '0' ? 'pos' :
                            ($imprime['pctChange'] == '0' ? 'neutro' : 
                            ($imprime['pctChange'] > '0' ? 'neg' : 'neg')));
                        $sinal = ($imprime['pctChange'] < '0' ? '' :
                            ($imprime['pctChange'] == '0' ? '' : 
                            ($imprime['pctChange'] > '0' ? '+' : '+')));
                        echo '<div class="numbers">';                    
                        echo '<span class="value bra"> '.$imprime['name'].' R$'.number_format($imprime['ask'],'3',',','').'</span>';
                        echo ' <span class="data '.$cor.'">'.$sinal.' '.number_format($imprime['pctChange'],'2',",",".").'% </span>';
                        echo '</div>';
                    }							
                @endphp
            </div>
        </div>
    </section>
@endsection

@section('css')
    <style>
        /* COTAÇÃO DO DÓLAR*/
        .cotacao{
            color:#333;
            text-align: left;
            box-shadow: 0 10px 20px rgba(0,0,0,.19),0 6px 6px rgba(0,0,0,.23)!important;
            min-height: 200px;
        }
        .numbers{
            font-weight: 400;
            letter-spacing: .6px;
        }
        .neg {
            background-color: #d5150b;   
            color:#fff; 
        }
        .pos {
            background-color: #20c634;
        }
        .neutro{
            background: rgb(204, 204, 204);
        }
    </style>
@endsection

@section('js')
  
@endsection