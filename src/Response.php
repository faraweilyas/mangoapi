<?php

namespace MangoAPI;

class Response
{
	private $statusCode;
	private $message;
	private $responseData;
	private $responseType;
	private $responseTypes = ["1**" => "information", "2**" => "success", "3**" => "redirect", "4**" => "client error", "5**" => "server error"];

	/**
	* Get response.
	* @return string
	*/
    public function __toString() : string
    {
		return $this->getResponse();
    }

	/**
	* Get response.
	* @param string
	*/
	public function getResponse() : string
	{
		return json_encode([
			'statusCode'    => $this->statusCode,
			'responseType'  => $this->responseType,
			'message'       => $this->message,
			'responseData'  => $this->responseData
		]);
	}

	/**
	* Request is ok.
	* @param string $message
	* @param array $responseData
	* @param Response
	*/
	public function isOk(string $message, ...$responseData) : Response
	{
		$this->statusCode 	= 'HTTP/1.1 200 OK';
		$this->responseType	= $this->responseTypes['2**'];
		$this->message 		= $message;
		$this->responseData = json_encode($responseData);
		return $this;
	}

	/**
	* Request is created.
	* @param string $message
	* @param array $responseData
	* @param Response
	*/
	public function isCreated(string $message, ...$responseData) : Response
	{
		$this->statusCode 	= 'HTTP/1.1 201 Created';
		$this->responseType	= $this->responseTypes['2**'];
		$this->message 		= $message;
		$this->responseData = json_encode($responseData);
		return $this;
	}

	/**
	* Request is bad.
	* @param string $message
	* @param array $responseData
	* @param Response
	*/
	public function badRequest(string $message="Bad request", ...$responseData) : Response
	{
		$this->statusCode 	= 'HTTP/1.1 400 Bad request';
		$this->responseType	= $this->responseTypes['4**'];
		$this->message 		= $message;
		$this->responseData = json_encode($responseData);
		return $this;
	}

	/**
	* Request is not found.
	* @param string $message
	* @param array $responseData
	* @param Response
	*/
	public function notFound(string $message="Not found", ...$responseData) : Response
	{
		$this->statusCode 	= 'HTTP/1.1 404 Not found';
		$this->responseType	= $this->responseTypes['4**'];
		$this->message 		= $message;
		$this->responseData = json_encode($responseData);
		return $this;
	}

	/**
	* Request is an un processable entity response.
	* @param string $message
	* @param array $responseData
	* @param Response
	*/
	public function unProcessableEntityResponse(string $message='Invalid input', ...$responseData) : Response
	{
		$this->statusCode 	= 'HTTP/1.1 422 Unprocessable Entity';
		$this->responseType	= $this->responseTypes['4**'];
		$this->message 		= $message;
		$this->responseData = json_encode($responseData);
		return $this;
	}

	/**
	* Respond to request.
	* @param string $statusCode
	* @param string $responseType
	* @param string $message
	* @param array $responseData
	* @param void
	*/
	public function sendResponse(string $statusCode, string $responseType, string $message, ...$responseData)
	{
		$this->statusCode 	= $statusCode;
		$this->responseType	= $this->responseTypes[$responseType];
		$this->message 		= $message;
		$this->responseData = json_encode($responseData);
		return $this->send();
	}

	/**
	* Send response.
	* @return void
	*/
	public function send()
	{
		echo $this->getResponse();
		$statusCode = explode(" ", $this->statusCode)[1];
		http_response_code($statusCode);
		return $this;
	}

	/**
	* Kill script.
	* @return void
	*/
	public function kill()
	{
		exit;
	}
}
