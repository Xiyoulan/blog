<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            //标题
            $table->string('title')->index();
            //内容
            $table->text('content');
            //使用 Markdown 编辑内容但同时保存 HTML 版本
            $table->text('content_html');
            //作者id
            $table->integer('user_id')->unsigned()->index();
            //分类
            $table->integer('category_id')->unsigned()->index();
            //标签图片
            $table->string('page_image');
            $table->string('slug')->nullable();
            //是否草稿
            $table->boolean('is_draft')->default(0);
            //回复数
            $table->integer('reply_count')->unsigned()->default(0);
            //查看次数
            $table->integer('view_count')->unsigned()->default(0);
            //最后一个回复者
            $table->integer('last_reply_user_id')->unsigned()->default(0);
            //排序
            $table->integer('order')->unsigned()->default(0);
            $table->timestamps();
            //发表时间
            $table->timestamp('published_at')->index()->nullable();
            //删除时间 做软删除
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }

}
