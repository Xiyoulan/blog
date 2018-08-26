<?php

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;

class SyncArticleViewCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xiyoulan:sync-article-view-count {--D|date=yesterday : 缓存数据的时间段,支持yesterday 和 now 两种}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '同步缓存话题的浏览次数到数据库';

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
    public function handle(Article $article)
    {
        $date = $this->option('date');
        if($date=='yesterday'){
            $this->info('同步昨日数据开始');
            $article->syncViewCountOfYesterday();
            $this->info('同步成功!');
        }elseif ($date == 'now'){
            $this->info('同步今天数据开始');
            $article->syncViewCountNow();
            $this->info('同步成功!');
        }else{
            $this->error('date参数错误!');
        }

    }
}
