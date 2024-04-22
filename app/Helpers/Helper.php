<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use App\Http\Controllers\Controller;
use App\Models\Auditoria;
use App\Models\Empresa;
use App\Models\Fechamento;
use Carbon\Carbon;
use DateTime;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class Helper extends Controller
{

    public static function url(string $string)
    {
        $protocolo = config('app.env') === 'production' ? 'https://' : 'http://';
        $dominio = $_SERVER['HTTP_HOST'];
        $url = $protocolo . $dominio;
        $partes = explode("/api", $url);
        return $partes[0] . '/storage/' . $string . '/';
    }
    public static function getFileName(string $FileName)
    {
        $partes = explode("/icone", $FileName);
        return $partes[1];
    }

    public static function getValueFromInterval($data_inicial, $data_final)
    {
        $data_inicial = date('Y-m', strtotime($data_inicial));
        $data_final = date('Y-m', strtotime($data_final));

        $data = $data_inicial;

        $datas = array();

        for ($i = 0; $data <= $data_final; $i++) {
            $datas[$data] = [
                'year' => date("Y", strtotime($data)),
                'month' => date("m", strtotime($data)),
                'valor' => 0,
            ];
            $data = date('Y-m', strtotime("+$i month", strtotime($data_inicial)));
        }

        return $datas;
    }

    public static function getMonthYearPt($date)
    {

        $datetime = Carbon::createFromFormat('Y-m-d', $date);

        $month = $datetime->locale('pt_BR')->isoFormat('MMMM');
        $year = $datetime->format('Y');

        $date_formated = "$month/$year";

        return $date_formated;
    }

    /**
     * Store a new auditoria.
     *
     */
    public static function auditoria($acao = null, $tabela = null, $codigo = null, $descricao = null, $ip = null)
    {
        $user_id = Auth::user()->id;
        Auditoria::create(compact(
            'acao',
            'tabela',
            'codigo',
            'descricao',
            'user_id',
            'ip',
        ));
    }

    public static function fechamento($unidade = null, $conta_corrente_id = null, $data_baixa = null)
    {
        $data_baixa = Carbon::parse($data_baixa) ?? date('Y-m-d');

        return Fechamento::where('unidade_id', $unidade)
            ->where('conta_corrente_id', $conta_corrente_id)
            ->where('ano', $data_baixa->format('Y'))
            ->where('mes', $data_baixa->format('m'))
            ->first() ? true : false;
    }
    public static function addData($adjetivo = null, $data = null)
    {
        $vencimento = $data; // Sua data de vencimento

        // Criar um objeto DateTime a partir da data de vencimento
        $dtVencimento = new DateTime($vencimento);

        // Aumentar um mês à data de vencimento
        $dtVencimento->modify($adjetivo);

        // Formatando a nova data para o formato "Y-m-d"
        $novaDataVencimento = $dtVencimento->format("Y-m-d");

        return $novaDataVencimento; // Resultado: 2023-08-25
    }
    public static function connect()
    {
        $empresa = Empresa::first();
        if (!empty($empresa->url)) {
            $http = new Client([
                'base_uri' => $empresa->url,
                'verify' => false,
                'headers' => [
                    'Accept' => 'application/json',
                    'x-api-key' => $empresa->token
                ]
            ]);
            return $http;
        }
    }

    public static function convertPDF($path)
    {
        $pdfConvert = 'tools/PDFConvert14.jar';
        $cmd = "java -jar {$pdfConvert} \"{$path}\" \"{$path}\"";
        shell_exec($cmd);
    }

    public static function getValueFromInterval2($data_inicial, $data_final)
    {
        $data_inicial = Carbon::createFromFormat('Y-m-d', $data_inicial);
        $data_final = Carbon::createFromFormat('Y-m-d', $data_final);

        $data = $data_final;

        $datas = array();

        for ($i = 0; (($data->gt($data_inicial) || $data->eq($data_inicial)) && $i <= 12); $i++) {
            $datas[$data->format('Y-m')] = [
                'ano' => $data->format("Y"),
                'mes' => $data->format("m"),
                'valor' => 0,
            ];
            $data = $data->subMonths();
        }

        return array_reverse($datas);
    }
    public static function EmpresaGlobal(){
        $empresa = Empresa::first();
        return $empresa->global;
    }
    public static function gerarSenha($tamanho =8) {
        // Defina os caracteres possíveis que você deseja usar na senha
        $caracteres = 'abcdefghijklmnopqrstuvwxyz0123456789';
        
        // Embaralhe os caracteres
        $senha = str_shuffle($caracteres);
        
        // Retorne apenas os primeiros $tamanho caracteres
        return substr($senha, 0, $tamanho);
    }
}
