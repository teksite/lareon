<?php

namespace Teksite\Lareon\Services\Builder;

use AllowDynamicProperties;
use Closure;
use Teksite\Handler\Actions\ServiceResult;
use Teksite\Handler\Actions\ServiceWrapper;
use Teksite\Lareon\Enums\ResponseType;
use Teksite\Lareon\Services\WebResponseServices;

class WebResponse
{
    private WebResponseServices $response;
    public function __construct()
    {
        $this->response = new WebResponseServices();
    }

    public function redirect(): WebResponse
    {
        return $this;
    }

    public function message(string $message)
    {
        $this->response->setMessage($message);
        return $this;
    }

    public function title(string $title)
    {
        $this->response->setTitle($title);
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

    public function route(string|null $route)
    {
        $this->response->setRoute($route);
        return $this;
    }


    public function byResult(ServiceResult $result, ?string $success_route = null, ?string $success_message = null, ?string $failed_route = null, ?string $failed_message = null)
    {
        if ($result->success) {
            $this->message($success_message ?? __('successfully done'))->result(ResponseType::SUCCESS)->data($result->result)->route($success_route ?? null);
        } else {
            $this->message($failed_message ?? __('unfortunately failed'))->result(ResponseType::FAILED)->data($result->result)->route($failed_route ?? null);
        }
        return $this;

    }

    public function go()
    {
        return $this->response->redirect();
    }


}
