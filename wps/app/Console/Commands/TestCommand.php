<?php

namespace App\Console\Commands;

use WpStarter\Console\Command;
use WpStarter\Support\Facades\DB;
use WpStarter\Wordpress\Auth\User;

class TestCommand extends Command
{
    protected $signature='test';
    function handle(){
        $query=User::query()->where('ID',1);
        if($query instanceof User\QueryBuilder){
            $user=$query->first();
            dd($user);
        }
    }
}