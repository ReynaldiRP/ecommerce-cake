<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefreshEnhancedDataSeeder extends Seeder
{
    /**
     * Refresh database with enhanced realistic data.
     */
    public function run(): void
    {
        $this->command->info("🔄 Refreshing database with enhanced realistic data...\n");

        // Clear existing order-related data
        $this->command->info("Clearing existing order data...");
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('payment_status_histories')->truncate();
        DB::table('order_status_histories')->truncate();
        DB::table('order_item_toppings')->truncate();
        DB::table('order_items')->truncate();
        DB::table('payments')->truncate();
        DB::table('orders')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info("✅ Existing data cleared.\n");

        // Run enhanced seeder
        $this->command->info("🎯 Generating enhanced realistic order data...");
        $this->call(EnhancedOrderSeeder::class);

        $this->command->info("✅ Enhanced data generated successfully!\n");

        // Show analysis
        $this->call(DataAnalysisSeeder::class);
    }
}
