<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Scripts', function (Blueprint $table) {
            $table->id();
            $table->string('number')->nullable();
            $table->string('title')->nullable();
            $table->string('broadcast_year')->nullable();
            $table->string('genre')->nullable();
            $table->string('continue')->nullable();
            $table->string('company')->nullable();
            $table->string('script_writer')->nullable();
            $table->string('original_writer')->nullable();
            $table->string('original_name')->nullable();
            $table->string('producer')->nullable();
            $table->string('performance')->nullable();
            $table->string('cast')->nullable();
            $table->string('outline')->nullable();
            $table->string('extra')->nullable();
            $table->string('owner')->nullable();
            $table->string('management_number')->nullable();
            $table->string('keyword')->nullable();
            $table->text('image')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();

            /*
                番号
                放送年
                タイトル
                ジャンル
                単発/連続
                放送系列/制作局
                脚本家
                原作者
                プロデューサー
                演出
                キャスト
                作品概要
                備考欄
                脚本所蔵
                管理番号
                検索キーワード
            */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('Scripts');
    }
};
