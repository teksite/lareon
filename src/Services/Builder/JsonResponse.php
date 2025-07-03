<?php

namespace Teksite\Lareon\Services\Builder;

use AllowDynamicProperties;
use Closure;
use Teksite\Handler\Actions\ServiceResult;
use Teksite\Handler\Actions\ServiceWrapper;
use Teksite\Lareon\Enums\ResponseType;
use Teksite\Lareon\Services\JsonResponseServices;
use Teksite\Lareon\Services\WebResponseServices;

class JsonResponse
{
    private JsonResponseServices $response;
    public function __construct()
    {
        $this->response = new JsonResponseServices();
    }

    public function response(): JsonResponse
    {
        return $this;
    }

    public function message(string $message)
    {
        $this->response->setMessage($message);
        return $this;
    }

    public function result(ResponseType $type)
    {
        $this->response->setResult($type);

        return $this;
    }

    public function data(mixed $data)
    {
        $this->response->setData($data);

        return $this;
    }
    public function status(int|string $status =200)
    {
        $this->response->setStatus($status);
        return $this;
    }


    public function byResult(ServiceResult $result,  $success_message = null, ?string $failed_message = null)
    {
        if ($result->success) {
            $this->message($success_message ?? __('successfully done'))->result(ResponseType::SUCCESS)->data($result->result)->status($result->successStatus ?? 200);
        } else {
            $this->message($failed_message ?? __('something goes wrong'))->result(ResponseType::Error)->data($result->result)->status(500);

        }
        return $this;

    }

    public function reply()
    {
        return $this->response->response();
    }


}
