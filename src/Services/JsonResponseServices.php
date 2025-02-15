<?php

namespace Teksite\Lareon\Services;

use AllowDynamicProperties;
use Closure;
use Teksite\Lareon\Enums\ResponseType;

#[AllowDynamicProperties] class JsonResponseServices
{
    private ?string $message = null;
    private ResponseType $result = ResponseType::SUCCESS;
    private mixed $data = null;
    private int|string $status = 200;


    public function setMessage(?string $message=null): void
    {
        $this->message = $message;
    }
    public function setResult(ResponseType $type): void
    {
        $this->type = $type;
    }
    public function setData(mixed $data = null): void
    {
        $this->data = $data;
    }

    public function setStatus(string|int $data = 200): void
    {
        $this->status = $data;
    }
    public function response()
    {
        return response()->json([
            'message' => $this->message,
            'result' => $this->result,
            'data' => $this->data,
        ])->setStatusCode($this->status);
    }


}
