<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesForHomepageOptimization extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add indexes for logged_devices table (if table exists and indexes don't exist)
        if (Schema::hasTable('logged_devices')) {
            Schema::table('logged_devices', function (Blueprint $table) {
                // Check if indexes don't already exist before creating them
                if (!$this->indexExists('logged_devices', 'user_device_ip_index')) {
                    $table->index(['user_id', 'device_name', 'user_ip'], 'user_device_ip_index');
                }
                if (!$this->indexExists('logged_devices', 'user_ip_index')) {
                    $table->index('user_ip', 'user_ip_index');
                }
            });
        }

        // Add index for home_settings table (if exists)
        if (Schema::hasTable('home_settings')) {
            Schema::table('home_settings', function (Blueprint $table) {
                if (!$this->indexExists('home_settings', 'theme_choosen_index')) {
                    $table->index('theme_choosen', 'theme_choosen_index');
                }
            });
        }

        // Add index for order_home_settings table (if exists)
        if (Schema::hasTable('order_home_settings')) {
            Schema::table('order_home_settings', function (Blueprint $table) {
                if (!$this->indexExists('order_home_settings', 'order_id_index')) {
                    $table->index('order_id', 'order_id_index');
                }
                if (!$this->indexExists('order_home_settings', 'video_name_index')) {
                    $table->index('video_name', 'video_name_index');
                }
            });
        }
    }

    /**
     * Check if an index exists on a table
     */
    private function indexExists($table, $index)
    {
        $indexes = Schema::getConnection()->getDoctrineSchemaManager()->listTableIndexes($table);
        return array_key_exists($index, $indexes);
    }

    public function down()
    {
        Schema::table('logged_devices', function (Blueprint $table) {
            $table->dropIndex('user_device_ip_index');
            $table->dropIndex('user_ip_index');
        });

        Schema::table('home_settings', function (Blueprint $table) {
            $table->dropIndex('theme_choosen_index');
        });

        if (Schema::hasTable('order_home_settings')) {
            Schema::table('order_home_settings', function (Blueprint $table) {
                $table->dropIndex('order_id_index');
                $table->dropIndex('video_name_index');
            });
        }
    }
}
