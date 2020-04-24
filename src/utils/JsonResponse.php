<?php


class JsonResponse
{

    public $responseCode;

    public $responseDescription;

    public $data;

    /**
     * JsonResponse constructor.
     */
    public function __construct(bool $response = false, string $msg = "No data sent!", $data = null )
    {
        $this->responseCode = $response ? "00" : "-01";
        $this->responseDescription = $msg;
        $this->data = $data;
    }


}