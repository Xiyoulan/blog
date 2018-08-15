<?php

namespace App\Console\Commands;

use App\Models\Tag;
use Illuminate\Console\Command;

class CalculateHotTags extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xiyoulan:calculate-hot-tags';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '计算tag的热度';

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
    public function handle()
    {
         $this->info("开始计算...");
        Tag::calculateAndCacheHotTags();
         $this->info("计算完成...");
    }
}
