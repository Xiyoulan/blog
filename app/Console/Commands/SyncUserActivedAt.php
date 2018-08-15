<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class SyncUserActivedAt extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xiyoulan:sync-user-actived-at';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '同步缓存的用户活跃时间到数据库';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(User $user)
    {
        $user->syncUserActivedAt();
        $this->info("同步成功！");
    }

}
