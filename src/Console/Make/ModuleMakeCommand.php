<?php

namespace Teksite\Lareon\Console\Make;

use Illuminate\Console\Command;

class ModuleMakeCommand extends Command
{
    protected $signature = 'lareon:make-module {name}
    ';


    protected $description = 'Create a new module managed by Lareon';

    protected string $type = 'Module';



    public function handle(){
       $this->call("module:make" ,[
           'name' => $this->argument('name'),
           '--lareon' => 'default',
       ]);

    }

}
