<?php
namespace Dialect\Internetx\Builders;

use Dialect\Internetx\Exceptions\InternetxException;
use Dialect\Internetx\Models\Model;
use Dialect\Internetx\Models\ModelFactory;
use GuzzleHttp\Client;

class Builder {
	public $url = 'https://gateway.autodns.com';
	public $username;
	public $password;
	public $context = 4;
	public $code;

	public $tasks = [];

	public function __construct($code = '0') {
		$this->username = config('internetx.auth.username');
		$this->password = config('internetx.auth.password');
		$this->code = $code;
	}

	public function auth($username, $password){
		$this->username = $username;
		$this->password = $password;
		return $this;
	}

	public function context($context){
		$this->context = $context;
		return $this;
	}

	public function toXml(){
		$dom = new \DOMDocument;
		$dom->formatOutput = TRUE;
		$dom->preserveWhiteSpace = FALSE;
		$dom->loadXML('<request/>');

		//auth
		$auth = $dom->createElement("auth");
		$user =  $dom->createElement("user", $this->username);
		$password = $dom->createElement("password", $this->password);
		$context = $dom->createElement("context", $this->context);

		$auth->appendChild($user);
		$auth->appendChild($password);
		$auth->appendChild($context);

		$dom->documentElement->appendChild($auth);

		//task
		$task = $dom->createElement("task");
		$code =  $dom->createElement("code", $this->code);

		$task->appendChild($code);
		$this->addNodeValues($dom, $task, $this->tasks);
		$dom->documentElement->appendChild($task);

		return html_entity_decode($dom->saveXML(), ENT_COMPAT, 'UTF-8');
	}

	protected function addNodeValues($dom, &$node, $array){

		foreach($array as  $fields){
			if(!array_key_exists('key', $fields)) dd($array, $fields);
			$element = $dom->createElement($fields['key']);
			if(is_array($fields['value'])){
				$this->addNodeValues($dom, $element, $fields['value']);
			}
			else{
				$element->nodeValue = $fields['value'];
			}
			$node->appendChild($element);
		}
	}

	public function sendQuery(){
		$query = $this->toXml();

		$client = new Client();

		$response = $client->post($this->url, [
			'body' => $query,
			'headers'  => ['content-type' => 'text/xml'],
		]);
		$result = json_decode(json_encode(simplexml_load_string($response->getBody()->getContents())));

		if(!$result){
			throw new InternetxException('Could not connect to: ' .$this->url);
		}
		else if($result->result->status->type == 'error'){
			throw new InternetxException($result->result->status->code.': '.$result->result->status->text);
		}
		return $this->parseQueryResultToModels($result);
	}

	protected function parseQueryResultToModels($result){
		$models = collect();

		foreach($result->result->data as $type => $value){
			if($type == 'summary') continue;

			if(is_array($value)){
				foreach($value as $data){
					$models->push(ModelFactory::create($type, $data));
				}
			}else{
				$models->push(ModelFactory::create($type, $value));
			}

		}

		return $models;
	}


}