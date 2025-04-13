<?php

namespace Lareon\CMS\App\Enums;

enum ActionTypesEnum: string
{
    case DELETE ='delete';
    case CHANGE ='update';
    case NEW ='create';
}
