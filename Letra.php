<?php

class Letra
{
	private const VERSAO = '1.0.0';
	private const DS = DIRECTORY_SEPARATOR;
	private const BASE = "https://api.vagalume.com.br/search.php";
	private const PASTA = __DIR__.self::DS.'letras';
	private $chave = CHAVE;
	private $nome = 'Ouvir Música';
	private $id;
	private $artista;
	private $musica;


	public function __construct($id,$artista,$musica)
	{
		$this->id = $id;
		$this->artista = $artista;
		$this->musica = $musica;
	}

	public function pegarLetra($update = false)
	{
		if(file_exists(self::PASTA.self::DS.$this->id.'.txt') && $update == false){
			return file_get_contents(self::PASTA.self::DS.$this->id.'.txt');
		}

		return $this->buscarLetra();
	}



	public function buscarLetra()
	{
		$letra = (object) json_decode($this->http());
		if($letra->type === 'exact'){
			$body  = '<header><h1>'."Letra {$letra->mus[0]->name} - {$letra->art->name}</h1></header>";
			$body .= $letra->mus[0]->text.PHP_EOL.PHP_EOL;
			$body .= "Letra by - <a href=\"https://www.vagalume.com.br\">Vagalume.com.br</a>".PHP_EOL;
			$body .= "Artista - <a href=\"{$letra->art->url}\" >{$letra->art->name}</a>".PHP_EOL;
			$body .= "Música - <a href=\"{$letra->mus[0]->url}\" >{$letra->mus[0]->name}</a>";
			return $this->salvar($body);
		}
		return '';

	}

	private function salvar($body)
	{
		$body = $this->formatar($body);
		file_put_contents(self::PASTA.self::DS.$this->id.'.txt',$body);
		return $body;
	}

	private function formatar($body)
	{
		return str_replace("\n", '<br>'.PHP_EOL, $body);
	}

	private function http()
	{
		$url = self::BASE."?art=".urlencode($this->artista)."&mus=".urlencode($this->musica)."&apiKey={$this->chave}";
		$curl = curl_init();
		curl_setopt_array($curl,[
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
		]);

		$response = curl_exec($curl);
		curl_close($curl);
		return $response;

	}
	//comentário


}

