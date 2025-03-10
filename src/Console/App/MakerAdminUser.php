<?php

namespace Teksite\Lareon\Console\App;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Teksite\Lareon\Traits\GeneralCommandsTrait;

class MakerAdminUser extends Command
{
    use GeneralCommandsTrait;

    protected $signature = 'lareon:make-admin';

    protected $description = 'make admin user';

    public function handle()
    {

    }
}
