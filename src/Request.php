<?php

namespace MangoAPI;

class Request
{
	private $headers = [];
	private $requestData;
	private $requestMethod;
	private $requestMethods = ["GET", "POST", "PUT", "HEAD", "DELETE", "PATCH", "OPTIONS"];

	/**
	* Constructor.
	* @param array $requestMethods
	* @return void
	*/
	public function __construct(...$requestMethods)
	{
		$this->setDataFromRequest();
		$this->setAllowMethods($requestMethods)->setHeaders();
	}

	/**
	* Add header.
	* @param string $header
	* @param string $value
	* @return Request
	*/
	public function addHeader(string $header, string $value) : Request
	{
		$this->headers[$header] = $value;
		return $this;
	}

	/**
	* Set allow methods header.
	* @param array $requestMethods
	* @return Request
	*/
	public function setAllowMethods(array $requestMethods=[]) : Request
	{
		$validRequestMethods = [];
		foreach ($requestMethods as $requestMethod):
			if (in_array(strtoupper($requestMethod), $this->requestMethods)):
				$validRequestMethods[] = strtoupper($requestMethod);
			endif;
		endforeach;
		$this->requestMethod = join(",", $validRequestMethods);
		return $this->addHeader("Access-Control-Allow-Methods", $this->requestMethod);
	}

	/**
	* Get allow methods header.
	* @param bool $array
	* @return mixed
	*/
	public function getAllowMethods(bool $array=FALSE)
	{
		return ($array) ? explode(',', $this->requestMethod) : $this->requestMethod;
	}

	/**
	* Set generic headers.
	* @return Request
	*/
	public function setGenericHeaders() : Request
	{
		return $this->addHeader("Access-Control-Allow-Origin", "*")
			->addHeader("Content-Type", "application/json; charset=UTF-8")
			->setAllowMethods(["GET", "POST", "PUT", "HEAD", "DELETE", "PATCH", "OPTIONS"])
			->addHeader("Access-Control-Max-Age", "3600")
			->addHeader("Access-Control-Allow-Credentials", "true")
			->addHeader("Access-Control-Allow-Headers", "Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With")
			->setHeaders();
	}

	/**
	* Set headers.
	* @return Request
	*/
	public function setHeaders() : Request
	{
		foreach ($this->headers as $header => $value):
			header("{$header}: $value");
		endforeach;
		return $this;
	}

	/**
	* Get headers.
	* @return array
	*/
	public function getHeaders() : array
	{
		$headers = [];
		foreach (headers_list() as $header):
			list($header, $value) = explode(":", $header);
			$headers[$header] = $value;
		endforeach;
		return $headers;
	}

	/**
	* Set data from request.
	* @return Request
	*/
	public function setDataFromRequest(bool $assoc=FALSE) : Request
	{
		$rawData 			= (array) json_decode(file_get_contents('php://input'), $assoc);
		$this->requestData 	= (object) [
			'rawData' 	=> $rawData,
			'getData' 	=> $_GET,
			'postData' 	=> $_POST,
			'filesData' => $_FILES,
		];
		return $this;
	}

	/**
	* Get data from request.
	* @return object
	*/
	public function getDataFromRequest() : \stdClass
	{
		return (object) $this->requestData;
	}
}
