<?php

namespace Teksite\Lareon\Console\App;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
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
        $userClass = Config::get('auth.providers.users.model');
        $userInstance = resolve($userClass);
        $fillables = $userInstance->getFillable();
        $inputs=[];
        foreach ($fillables as $fillable) {
            $answer = $this->askRecursive("enter a/an $fillable for admin user");
            $inputs[$fillable] = $fillable === 'password' ? hash::make($answer) : $answer;
        }
        $userClass::query()->insert($inputs);
    }

    public function askRecursive(string $message)
    {
        $answer= $this->ask($message);
        if (is_null($answer) || trim($answer) === '' || preg_match('/[!#$%^&*()+={}\[\];:\'\"\/?>,<]/', $answer)) {
            $this->error("$answer in not acceptable");
            $answer = $this->askRecursive($message);
        }
        return $answer;

    }

}
