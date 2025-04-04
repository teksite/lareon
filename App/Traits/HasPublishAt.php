<?php

namespace Lareon\CMS\App\Traits;

trait HasPublishAt
{
    private string $local;
    public function __construct()
    {
        $this->local= app()->getLocale();
    }

    public function adapteDate($timestamp =null)
    {
        if($timestamp==null){
        }
    }

}
