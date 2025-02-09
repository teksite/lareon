<?php

namespace Teksite\Lareon\Enums;

enum ResponseType :string
{
    case SUCCESS = 'success';
    case FAILED = 'failed';
    case WARNING = 'warning';
    case INFO = 'info';
}
