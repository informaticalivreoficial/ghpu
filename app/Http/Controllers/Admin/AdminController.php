<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CatPost;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Analytics;
use App\Models\Empresa;
use App\Models\Ocorrencia;
use Illuminate\Support\Facades\Redirect;
use Spatie\Analytics\Period;

class AdminController extends Controller
{
    public function home()
    {
        if(Auth::user()->editor == 1){
            return Redirect::route('colaborador');
        }

        //Users
        $time = User::where('admin', 1)->count();
        $colaboradores = User::where('editor', 1)->count();
        //Clientes
        $empresasAvailable = Empresa::available()->count();
        $empresasUnavailable = Empresa::unavailable()->count();
        //Ocorrências
        $ocorrenciasAvailable = Ocorrencia::available()->count();
        $ocorrenciasUnavailable = Ocorrencia::unavailable()->count();
        //Newsletter
        // $listas = NewsletterCat::count();
        // $emails = Newsletter::count();
        // $emailsCount = Newsletter::get();
        //CHART PIZZA
        $postsArtigos = Post::where('tipo', 'artigo')->count();
        $postsPaginas = Post::where('tipo', 'pagina')->count();
        $postsNoticias = Post::where('tipo', 'noticia')->count();
             
        //Artigos
        $artigosAvailable = Post::postson()->where('tipo', 'artigo')->count();
        $artigosUnavailable = Post::postsoff()->where('tipo', 'artigo')->count();
        $artigosTop = Post::orderBy('views', 'DESC')
                ->where('tipo', 'artigo')
                ->limit(6)
                ->postson()   
                ->get();                
        $totalViewsArtigos = Post::orderBy('views', 'DESC')
                ->where('tipo', 'artigo')
                ->postson()
                ->limit(6)
                ->get()
                ->sum('views');
        //Páginas
        $paginasTop = Post::orderBy('views', 'DESC')
                ->where('tipo', 'pagina')
                ->limit(6)
                ->postson()   
                ->get();
        $totalViewsPaginas = Post::orderBy('views', 'DESC')
                ->where('tipo', 'pagina')
                ->postson()
                ->limit(6)
                ->get()
                ->sum('views');

        //Analitcs
        $visitasHoje = Analytics::fetchMostVisitedPages(Period::days(1));
        $visitas365 = Analytics::fetchTotalVisitorsAndPageViews(Period::months(5));
        $top_browser = Analytics::fetchTopBrowsers(Period::months(5));

        
        $analyticsData = Analytics::performQuery(
            Period::months(5),
               'ga:sessions',
               [
                   'metrics' => 'ga:sessions, ga:visitors, ga:pageviews',
                   'dimensions' => 'ga:yearMonth'
               ]
         );         
        
        return view('admin.dashboard',[
            'time' => $time,
            'colaboradores' => $colaboradores,
            //Artigos
            'artigosAvailable' => $artigosAvailable,
            'artigosUnavailable' => $artigosUnavailable,
            'artigosTop' => $artigosTop,
            'artigostotalviews' => $totalViewsArtigos,
            //Páginas
            'paginasTop' => $paginasTop,
            'paginastotalviews' => $totalViewsPaginas,
            //Empresas
            'empresasAvailable' => $empresasAvailable,
            'empresasUnavailable' => $empresasUnavailable,
            //Ocorrências
            'ocorrenciasAvailable' => $ocorrenciasAvailable,
            'ocorrenciasUnavailable' => $ocorrenciasUnavailable,
            'postsArtigos' => $postsArtigos,
            'postsNoticias' => $postsNoticias,
            'postsPaginas' => $postsPaginas,
            //Analytics
            'visitasHoje' => $visitasHoje,
            //'visitas365' => $visitas365,
            'analyticsData' => $analyticsData,
            'top_browser' => $top_browser
        ]);
    }

    public function colaborador()
    {
        $ocorrências = Ocorrencia::orderBy('created_at', 'DESC')->available()->paginate(25);
        return view('admin.colaborador',[
            'ocorrências' => $ocorrências
        ]);
    }
}
