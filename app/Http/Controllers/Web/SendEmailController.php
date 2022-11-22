<?php

namespace App\Http\Controllers\Web;

use App\Helpers\Renato;
use App\Http\Controllers\Controller;
use App\Mail\Admin\AvaliacaoCriada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Web\Atendimento;
use App\Mail\Web\AtendimentoRetorno;
use App\Mail\Web\ReservaRetorno;
use App\Mail\Web\ReservaSend;
use App\Models\Apartamento;
use App\Models\Avaliacoes;
use App\Models\Empresa;
use App\Models\Newsletter;
use App\Models\NewsletterCat;
use App\Models\Reservas;
use App\Models\User;
use App\Services\CidadeService;
use App\Services\ConfigService;
use App\Services\EstadoService;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SendEmailController extends Controller
{
    protected $configService, $estadoService, $cidadeService;

    public function __construct(
        ConfigService $configService, 
        EstadoService $estadoService, 
        CidadeService $cidadeService)
    {
        $this->configService = $configService;
        $this->cidadeService = $cidadeService;
        $this->estadoService = $estadoService;
    }

    public function sendEmail(Request $request)
    {
        if($request->nome == ''){
            $json = "Por favor preencha o campo <strong>Nome</strong>";
            return response()->json(['error' => $json]);
        }
        if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)){
            $json = "O campo <strong>Email</strong> está vazio ou não tem um formato válido!";
            return response()->json(['error' => $json]);
        }
        if($request->mensagem == ''){
            $json = "Por favor preencha sua <strong>Mensagem</strong>";
            return response()->json(['error' => $json]);
        }
        if(!empty($request->bairro) || !empty($request->cidade)){
            $json = "<strong>ERRO</strong> Você está praticando SPAM!"; 
            return response()->json(['error' => $json]);
        }else{
            $data = [
                'sitename' => $this->configService->getConfig()->nomedosite,
                'siteemail' => $this->configService->getConfig()->email,
                'reply_name' => $request->nome,
                'reply_email' => $request->email,
                'mensagem' => $request->mensagem
            ];

            $retorno = [
                'sitename' => $this->configService->getConfig()->nomedosite,
                'siteemail' => $this->configService->getConfig()->email,
                'reply_name' => $request->nome,
                'reply_email' => $request->email
            ];
            
            Mail::send(new Atendimento($data));
            Mail::send(new AtendimentoRetorno($retorno));
            
            $json = "Obrigado {$request->nome} sua mensagem foi enviada com sucesso!"; 
            return response()->json(['sucess' => $json]);
        }
    }

    public function sendNewsletter(Request $request)
    {
        if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)){
            $json = "O campo <strong>Email</strong> está vazio ou não tem um formato válido!";
            return response()->json(['error' => $json]);
        }
        if(!empty($request->bairro) || !empty($request->cidade)){
            $json = "<strong>ERRO</strong> Você está praticando SPAM!";  
            return response()->json(['error' => $json]);
        }else{   
            $validaNews = Newsletter::where('email', $request->email)->first();            
            if(!empty($validaNews)){
                Newsletter::where('email', $request->email)->update(['status' => 1]);
                $json = "Obrigado Cadastro realizado com sucesso!"; 
                return response()->json(['sucess' => $json]);
            }else{
                $categoriaPadrão = NewsletterCat::where('sistema', 1)->first();                
                $data = $request->all();
                $data['autorizacao'] = 1;
                $data['categoria'] = $categoriaPadrão->id;
                $data['nome'] = $request->nome ?? '#Cadastrado pelo Site';
                $NewsletterCreate = Newsletter::create($data);
                $NewsletterCreate->save();
                $json = "Obrigado Cadastrado com sucesso!"; 
                return response()->json(['sucess' => $json]);
            }            
        }
    }

    public function acomodacaoSend(Request $request)
    {        
        $apartamento = Apartamento::where('id', $request->apart_id)->first();

        if($request->tipo_reserva == 1){
            if($request->empresa_nome == ''){
                $json = "Por favor preencha o campo <strong>Nome da Empresa</strong>";
                return response()->json(['error' => $json]);
            }
            if($request->cnpj == ''){
                $json = "Por favor preencha o campo <strong>CNPJ da Empresa</strong>";
                return response()->json(['error' => $json]);
            }
            if($request->telefone_empresa == ''){
                $json = "Por favor preencha o campo <strong>Telefone da Empresa</strong>";
                return response()->json(['error' => $json]);
            }
        }

        if($request->nome == ''){
            $json = "Por favor preencha o campo <strong>Nome</strong>";
            return response()->json(['error' => $json]);
        }

        if(!\App\Helpers\Renato::validaCPF($request->cpf)){
            $json = "O campo <strong>CPF</strong> está vazio ou não tem um formato válido!";
            return response()->json(['error' => $json]);
        }

        if($request->rg == ''){
            $json = "Por favor preencha o campo <strong>RG</strong>";
            return response()->json(['error' => $json]);
        }

        $nasc = Carbon::createFromFormat('d/m/Y', $request->nasc)->format('d-m-Y');        
        
        if(Carbon::parse($nasc)->age < 18){
            $json = "Data de nascimento inválida!";
            return response()->json(['error' => $json]);
        }

        if($request->nasc == ''){
            $json = "Por favor preencha o campo <strong>Dada de Nascimento</strong>";
            return response()->json(['error' => $json]);
        }
        
        if($request->telefone_cliente == ''){
            $json = "Por favor preencha o campo <strong>Telefone</strong>";
            return response()->json(['error' => $json]);
        }

        if($request->apart_id == ''){
            $json = "Por favor escolha um <strong>apartamento</strong>";
            return response()->json(['error' => $json]);
        }
        
        if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)){
            $json = "O campo <strong>Email</strong> está vazio ou não tem um formato válido!";
            return response()->json(['error' => $json]);
        }

        if($request->checkin == ''){
            $json = "Por favor selecione uma <strong>Data</strong> para seu CheckIn!";
            return response()->json(['error' => $json]);
        }

        if($request->checkout == ''){
            $json = "Por favor selecione uma <strong>Data</strong> para seu CheckOut!";
            return response()->json(['error' => $json]);
        }
        
        $data = [
            'sitename' => $this->configService->getConfig()->nomedosite,
            'siteemail' => env('MAIL_FROM_ADDRESS'),
            //Dados do Cliente
            'reply_name' => $request->nome,
            'reply_email' => $request->email,
            'cpf' => $request->cpf,
            'rg' => $request->rg,
            'nasc' => $request->nasc,
            'cep' => $request->cep,
            'rua' => $request->rua,
            'bairro' => $request->bairro,
            'num' => $request->num,
            'telefone' => $request->telefone_cliente,
            'whatsapp' => $request->whatsapp,
            'estado' => $this->estadoService->getEstado($request->uf)->estado_nome,
            'cidade' => $this->cidadeService->getCidadeById($request->cidade)->cidade_nome,
            //Dados da reserva
            'ocupacao' => ($request->ocupacao == 1 ? 'Com Café da manhã' : 'Sem Café da manhã'),
            'checkin' => $request->checkin,
            'checkout' => $request->checkout,
            'adultos' => $request->num_adultos,
            'criancas' => $request->num_cri_0_5,            
            'codigo' => '00'.rand(1,100000),
            'apartamento' => $apartamento->titulo
        ];
        
        $retorno = [
            'sitename' => $this->configService->getConfig()->nomedosite,
            'siteemail' => env('MAIL_FROM_ADDRESS'),
            'reply_name' => $request->nome,
            'reply_email' => $request->email
        ];
        
        $getEmpresa = Empresa::where('document_company', str_replace(['.', '-', '/', '(', ')', ' '], '', $request->cnpj))->first();
        if($request->tipo_reserva == 1){                        
            if(empty($getEmpresa)){
                $empresa = [
                    'alias_name' => $request->empresa_nome,
                    'social_name' => $request->empresa_nome,
                    'document_company' => $request->cnpj,
                    'telefone' => $request->telefone_empresa,
                    'created_at' => Carbon::now()
                ];
                $empresaCreate = Empresa::create($empresa);
                $empresaCreate->save();
            }            
        }
        
        $user = [
            'name' => $request->nome,
            'email' => $request->email,
            'cpf' => $request->cpf,
            'rg' => $request->rg,
            'celular' => $request->telefone_cliente,
            'whatsapp' => $request->whatsapp,
            'cep' => $request->cep,
            'rua' => $request->rua,
            'bairro' => $request->bairro,
            'num' => $request->num,
            'uf' => $request->uf,
            'cidade' => $request->cidade,
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt(Carbon::now()),
            'senha' => Str::random(20),
            'remember_token' => Str::random(20),
            'created_at' => Carbon::now(),
            'client' => true,
            'status' => 1,
            'notasadicionais' => 'Cliente cadastrado pelo site'
        ];        
        
        $userCreate = User::create($user);
        $userCreate->save();

        $reserva = [
            'cliente' => $userCreate->id,
            'apartamento' => $apartamento->id,
            'empresa' => ($request->tipo_reserva == 1 && !empty($getEmpresa) ? $empresaCreate->id : null),
            'status' => 1,
            'adultos' => $request->num_adultos,
            'criancas_0_5' => $request->num_cri_0_5,
            'codigo' => $data['codigo'],
            'checkin' => $request->checkin,
            'checkout' => $request->checkout,
            'notasadicionais' => $data['ocupacao']
        ];
        
        $reservaCreate = Reservas::create($reserva);
        $reservaCreate->save();

        Mail::send(new ReservaSend($data));
        Mail::send(new ReservaRetorno($retorno));   
        
        $json = "Obrigado {$request->nome} sua solicitação de pré-reserva foi enviada com sucesso!"; 
        return response()->json(['sucess' => $json]);
    }   
    
    public function avaliacaoSend(Request $request)
    {
        if($request->name == ''){
            $json = "Por favor preencha o campo <strong>Nome</strong>";
            return response()->json(['error' => $json]);
        }
        if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)){
            $json = "O campo <strong>Email</strong> está vazio ou não tem um formato válido!";
            return response()->json(['error' => $json]);
        }
        if($request->checkout == ''){
            $json = "Por favor selecione a <strong>Data</strong> do seu Check out!";
            return response()->json(['error' => $json]);
        }

        $data = $request->except(['_token', 'bairro', 'cidade']);
        
        //$createAvaliacao = Avaliacoes::create($data);
        //$createAvaliacao->save();

        Mail::send(new AvaliacaoCriada($data, $this->configService->getConfig()));

        //$json = "Obrigado {$request->name} sua avaliação foi enviada com sucesso!"; 
        //return response()->json(['sucess' => $json]);        
    }
}
