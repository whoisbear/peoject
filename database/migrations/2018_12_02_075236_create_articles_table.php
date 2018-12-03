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
            $table->string('title')->comment('标题');
            $table->unsignedInteger('classid')->comment('分类ID')->index();
            $table->unsignedTinyInteger('px')->comment('排序')->default(255);
            $table->string('remark')->comment('摘要')->nullable($value = true);
            $table->string('auther')->comment('作者')->default('官方');
            $table->string('from')->comment('文章来源')->default('官方内网');
            $table->tinyInteger('can_comment')->comment('能否评论')->default(1);
            $table->tinyInteger('stick')->comment('置顶')->default(0);
            $table->unsignedInteger('browse')->comment('浏览次数')->default(0);
            $table->string('cover')->comment('封面')->nullable($value = true);
            $table->text('content')->comment('内容');
            $table->tinyInteger('state')->comment('状态')->default(1)->index();
            $table->timestamps();
            $table->foreign('classid')->references('id')->on('article_classifies')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article');
    }
}
