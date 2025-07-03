<?php

namespace Teksite\Lareon\Services;

use AllowDynamicProperties;
use Closure;
use Teksite\Lareon\Enums\ResponseType;

class JsonResponseServices
{
    private ?string $message = null;
    private ResponseType $result;
    private mixed $data = null;
    private int|string $status;


    public function setMessage(?string $message=null): void
    {
        $this->message = $message;
    }
    public function setResult(ResponseType $type): void
    {
        $this->result = $type;
    }
    public function setData(mixed $data = null): void
    {
        $this->data = $data;
    }

    public function setStatus(string|int $status = 200): void
    {
        $this->status = $status;
    }
    public function response()
    {
        return response()->json([
            'message' => $this->message,
            'result' => $this->result,
            'data' => $this->data,
            'status' => $this->status,
        ])->setStatusCode($this->status);
    }


}
