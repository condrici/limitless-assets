<?php

namespace App\Http\Response;

use Illuminate\Http\Response;

class ApiResponseBuilder
{
    private int $statusCode;
    private ?array $data;
    private ?int $totalMeta;

    public function withStatusCode(int $statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function withData(array $data)
    {
        $this->data = $data;
        return $this;
    }

    public function withTotalMeta(int $total)
    {
        $this->totalMeta = $total;
        return $this;
    }

    public function build(): Response
    {
        $response = [];

        $statusCode = $this->statusCode;
        if (!isset($statusCode)) {
            throw new \Exception('Status Code is mandatory, but it was not set');
        }

        if (isset($statusCode)) {
            $response['status'] = (int) substr(strval($statusCode), 0,1) === 2 ? 'success' : 'false';
        }

        if(isset($this->data)) {
            $response['data'] = $this->data;
        }

        if(isset($this->totalMeta)) {
            $response['meta']['total'] = $this->totalMeta;
        }

        $json = json_encode($response, JSON_PRETTY_PRINT);

        $this->reset();

        return response($json, $statusCode)
            ->header('Content-Type', 'text/javascirpt');
    }

    private function reset()
    {
        foreach (get_class_vars(get_class($this)) as $name => $default) {
            unset($this->$name);
        }
    }
}