<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrevisaoTempo extends Model
{
    use HasFactory;

    private $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function getContent()
    {
        $url = $this->url;

        if (empty($url)) {
            return null;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $this->url);    // get the url contents
        $data = curl_exec($ch); // execute curl request
        curl_close($ch);

        $result = simplexml_load_string($data);

        foreach($result->previsao as $item){
            $response[] = [
                'data' => Carbon::parse($item->dia)->translatedFormat('l d/m/Y'),
                'img' => $this->getImgPrevisao($item->tempo),
                'previsao' => $this->getPrevisao($item->tempo),
                'minima' => $item->minima,
                'maxima' => $item->maxima,
                'iuv' => $item->iuv,
                'iuvcolor' => $this->getUvColor($item->iuv)
            ];
        }

        return $response;
    }

    public function getPrevisao($sigla)
    {
        if (empty($sigla)) {
            return null;
        }

        $result =   ($sigla == 'ec' ? 'Encoberto com Chuvas Isoladas' :
                    ($sigla == 'ci' ? 'Chuvas Isoladas' :
                    ($sigla == 'c' ? 'Chuva' :
                    ($sigla == 'in' ? 'Instável' :
                    ($sigla == 'pp' ? 'Poss. de Pancadas de Chuva' :
                    ($sigla == 'cm' ? 'Chuva pela Manhã' :
                    ($sigla == 'cn' ? 'Chuva a Noite' :
                    ($sigla == 'pt' ? 'Pancadas de Chuva a Tarde' :
                    ($sigla == 'pm' ? 'Pancadas de Chuva pela Manhã' :
                    ($sigla == 'np' ? 'Nublado e Pancadas de Chuva' :
                    ($sigla == 'pc' ? 'Pancadas de Chuva' :
                    ($sigla == 'pn' ? 'Parcialmente Nublado' :
                    ($sigla == 'cv' ? 'Chuvisco' :
                    ($sigla == 'ch' ? 'Chuvoso' :
                    ($sigla == 't' ? 'Tempestade' :
                    ($sigla == 'ps' ? 'Predomínio de Sol' :
                    ($sigla == 'e' ? 'Encoberto' :
                    ($sigla == 'n' ? 'Nublado' :
                    ($sigla == 'cl' ? 'Céu Claro' :
                    ($sigla == 'nv' ? 'Nevoeiro' :
                    ($sigla == 'g' ? 'Geada' :
                    ($sigla == 'pnt' ? 'Pancadas de Chuva a Noite' :
                    ($sigla == 'psc' ? 'Possibilidade de Chuva' :
                    ($sigla == 'pcm' ? 'Possibilidade de Chuva pela Manhã' :
                    ($sigla == 'pct' ? 'Possibilidade de Chuva a Tarde' :
                    ($sigla == 'pcn' ? 'Possibilidade de Chuva a Noite' :
                    ($sigla == 'npt' ? 'Nublado com Pancadas a Tarde' :
                    ($sigla == 'npn' ? 'Nublado com Pancadas a Noite' :
                    ($sigla == 'ncn' ? 'Nublado com Poss. de Chuva a Noite' :
                    ($sigla == 'nct' ? 'Nublado com Poss. de Chuva a Tarde' :
                    ($sigla == 'ncm' ? 'Nubl. c/ Poss. de Chuva pela Manhã' :
                    ($sigla == 'npm' ? 'Nublado com Pancadas pela Manhã' :
                    ($sigla == 'npp' ? 'Nublado com Possibilidade de Chuva' :
                    ($sigla == 'vn' ? 'Variação de Nebulosidade' :
                    ($sigla == 'ct' ? 'Chuva a Tarde' :
                    ($sigla == 'ppn' ? 'Poss. de Panc. de Chuva a Noite' :
                    ($sigla == 'ppt' ? 'Poss. de Panc. de Chuva a Tarde' :
                    ($sigla == 'ppm' ? 'Poss. de Panc. de Chuva pela Manhã' : 'Erro'))))))))))))))))))))))))))))))))))))));
        
        return $result;
    }

    public function getImgPrevisao($sigla)
    {        
        if (empty($sigla)) {
            return null;
        }

        $result =   ($sigla == 'ec' ? 'sol-com-pancadas.png' :
                    ($sigla == 'ci' ? 'sol-com-pancadas.png' :
                    ($sigla == 'c' ? 'chuva.png' :
                    ($sigla == 'in' ? 'sol-com-pancadas.png' :
                    ($sigla == 'pp' ? 'sol-com-pancadas.png' :
                    ($sigla == 'cm' ? 'chuva.png' :
                    ($sigla == 'cn' ? 'chuva.png' :
                    ($sigla == 'pt' ? 'sol-com-pancadas.png' :
                    ($sigla == 'pm' ? 'sol-com-pancadas.png' :
                    ($sigla == 'np' ? 'sol-com-pancadas.png' :
                    ($sigla == 'pc' ? 'sol-com-pancadas.png' :
                    ($sigla == 'pn' ? 'encoberto.png' :
                    ($sigla == 'cv' ? 'chuva.png' :
                    ($sigla == 'ch' ? 'chuva.png' :
                    ($sigla == 't' ? 'tempestade.png' :
                    ($sigla == 'ps' ? 'sol.png' :
                    ($sigla == 'e' ? 'encoberto.png' :
                    ($sigla == 'n' ? 'nublado.png' :
                    ($sigla == 'cl' ? 'sol.png' :
                    ($sigla == 'nv' ? 'encoberto.png' :
                    ($sigla == 'pnt' ? 'pancadas-noite.png' :
                    ($sigla == 'psc' ? 'sol-com-pancadas.png' :
                    ($sigla == 'pcm' ? 'sol-com-pancadas.png' :
                    ($sigla == 'pct' ? 'sol-com-pancadas.png' :
                    ($sigla == 'pcn' ? 'sol-com-pancadas.png' :
                    ($sigla == 'npt' ? 'sol-com-pancadas.png' :
                    ($sigla == 'npn' ? 'sol-com-pancadas.png' :
                    ($sigla == 'ncn' ? 'sol-com-pancadas.png' :
                    ($sigla == 'nct' ? 'sol-com-pancadas.png' :
                    ($sigla == 'ncm' ? 'sol-com-pancadas.png' :
                    ($sigla == 'npm' ? 'sol-com-pancadas.png' :
                    ($sigla == 'npp' ? 'sol-com-pancadas.png' :
                    ($sigla == 'vn' ? 'encoberto.png' :
                    ($sigla == 'ct' ? 'sol-com-pancadas.png' :
                    ($sigla == 'ppn' ? 'sol-com-pancadas.png' :
                    ($sigla == 'ppt' ? 'sol-com-pancadas.png' :
                    ($sigla == 'ppm' ? 'sol-com-pancadas.png' : 'Erro')))))))))))))))))))))))))))))))))))));

        return $result;
    }

    public function getUvColor($valor)
    {
        if (empty($valor)) {
            return null;
        }

        if($valor <= '2'):
            $uv = 'color:#000;';
         elseif($valor >= '3' && $valor <= '5'):
            $uv = 'color:#000;background:#fff336;';
         elseif($valor >= '6' && $valor <= '7'):
            $uv = 'color:#000;background:#EDAC43;';
         elseif($valor >= '8' && $valor <= '10'):
            $uv = 'color:#fff;background:#D92927;';
         elseif($valor >= '11'):
            $uv = 'color:#fff;background:#C72BB2;';
         endif;

         return $uv;
    }
}
