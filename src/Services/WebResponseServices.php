<?php

namespace Teksite\Lareon\Services;

use AllowDynamicProperties;
use Closure;
use Teksite\Lareon\Enums\ResponseType;

class WebResponseServices
{
    private ?string $title = null;
    private ?string $message = null;
    private ResponseType $type;
    private mixed $data = null;
    private string|null $route = null;


    public function setTitle(?string $title=null): void
    {
        $this->title = $title;
    }
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
    public function setRoute(?string $route =null): void
    {
        $this->route = $route;
    }

    public function redirect()
    {
        $with = [];
        !is_null($this->title) && $with['title'] = $this->title;
        !is_null($this->message) && $with['message'] = $this->message;
        !is_null($this->type) && $with['type'] = $this->type->value;
        !is_null($this->data) && $with['data'] = $this->data;

       $redirect = $this->route ? redirect($this->route) : redirect()->back();
        return count($with) ? $redirect->with(['reply' => $with]) : $redirect;
    }
}
