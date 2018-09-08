<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create(
        'Settings', 
        function (Blueprint $oTable) 
        {
          $oTable->increments('iSettingID');
          $oTable->string('sName', 255);
          $oTable->string('sType', 255);
          $oTable->string('sValue', 255);
          $oTable->charset = 'utf8mb4';
          $oTable->collation = 'utf8_unicode_ci';
          $oTable->engine = 'InnoDB';
        }
      );
      Schema::create(
        'Modules', 
        function (Blueprint $oTable) 
        {
          $oTable->increments('iModuleID');
          $oTable->string('sName', 255);
          $oTable->boolean('bStatus');
          $oTable->charset = 'utf8mb4';
          $oTable->collation = 'utf8_unicode_ci';
          $oTable->engine = 'InnoDB';
        }
      );
      Schema::create(
        'Themes', 
        function (Blueprint $oTable) 
        {
          $oTable->increments('iThemeID');
          $oTable
              ->integer('iParentThemeID')
              ->nullable(false)
              ->default(0);
          $oTable->string('sName', 255);
          $oTable->boolean('bStatus');
          $oTable->charset = 'utf8mb4';
          $oTable->collation = 'utf8_unicode_ci';
          $oTable->engine = 'InnoDB';
        }
      );

      /*
      Schema::disableForeignKeyConstraints();
      Schema::dropIfExists('sessions');
      Schema::create('sessions', function (Blueprint $table) {
          //$table->increments('id');
          $table->string('id', 255)->unique();
          $table->unsignedInteger('user_id')->nullable();
          $table->string('ip_address', 45)->nullable();
          $table->text('user_agent')->nullable();
          $table->text('payload');
          $table->integer('last_activity');
      });
      Schema::dropIfExists('roles');
      Schema::create('roles', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name', 255);
      });
      Schema::dropIfExists('permissions');
      Schema::create('permissions', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name', 255);
      });
      Schema::dropIfExists('roles_permissions');
      Schema::create('roles_permissions', function (Blueprint $table) {
          $table->increments('id');
          $table->unsignedInteger('role_id')->nullable();
          $table->unsignedInteger('permission_id')->nullable();
      });
      Schema::dropIfExists('users');
      Schema::create('users', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->string('email')->unique();
          $table->string('password');
          $table->rememberToken();
          $table->timestamps();
          $table->unsignedInteger('role_id')->nullable();
      });
      Schema::table('users', function(Blueprint $table) {
        $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
      });
      Schema::dropIfExists('password_resets');
      Schema::create('password_resets', function (Blueprint $table) {
          $table->string('email')->index();
          $table->string('token');
          $table->timestamp('created_at')->nullable();
      });

      Schema::dropIfExists('order');
      Schema::create('order', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name', 255);
          $table->string('address', 255);
          $table->unsignedInteger('user_id')->nullable();
          $table->timestamps();
      });
      Schema::table('order', function(Blueprint $table) {
        $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
      });
      Schema::dropIfExists('cart');
      Schema::create('cart', function (Blueprint $table) {
          $table->increments('id');
          $table->string('products');
          $table->unsignedInteger('user_id')->nullable();
          $table->timestamps();
      });
      Schema::table('cart', function(Blueprint $table) {
        $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
      });
      Schema::dropIfExists('products');
      Schema::create('products', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name', 255);
          $table->text('description');
          $table->timestamps();
      });

      Schema::dropIfExists('pages');
      Schema::create('pages', function (Blueprint $table) {
          $table->increments('id');
          $table->string('uri', 255)->unique();
          $table->unsignedInteger('parent_id')->default(0);
          $table->string('layout_template', 255)->default('');
          $table->string('template', 255)->default('');
          $table->timestamps();
      });
      Schema::dropIfExists('posts');
      Schema::create('posts', function (Blueprint $table) {
          $table->increments('id');
          $table->string('title', 255);
          $table->text('content');
          $table->timestamps();
      });

      Schema::dropIfExists('iblocks');
      Schema::create('iblocks', function (Blueprint $table) {
          $table->increments('id');
          $table->timestamps();
      });
      Schema::dropIfExists('fields');
      Schema::create('fields', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('iblock_id')->unsigned()->nullable();
          $table->integer('language_id')->unsigned()->nullable();
          $table->string('name', 255);
          $table->string('type', 255);
      });
      Schema::table('fields', function (Blueprint $table) {
        $table->foreign('iblock_id')->references('id')->on('iblocks')->onDelete('set null');
      });
      Schema::dropIfExists('fields_values');
      Schema::create('fields_values', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('field_id')->unsigned()->nullable();
          $table->string('value', 255);
      });
      Schema::table('fields_values', function (Blueprint $table) {
        $table->foreign('field_id')->references('id')->on('fields')->onDelete('set null');
      });

      Schema::dropIfExists('languages');
      Schema::create('languages', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
      });

      Schema::dropIfExists('settings');
      Schema::create('settings', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name', 255);
          $table->string('type', 255);
          $table->string('value', 255);
      });
      Schema::enableForeignKeyConstraints();
      */
    }
}
