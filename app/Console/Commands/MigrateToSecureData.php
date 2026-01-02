<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class MigrateToSecureData extends Command
{
    protected $signature = 'app:migrate-to-secure-data';

    protected $description = 'Migrate existing purchase data to secure columns';

    public function handle()
    {
        $this->info('Starting data migration...');

        $purchases = DB::table('stock_purchases')->get();

        $bar = $this->output->createProgressBar(count($purchases));
        $bar->start();

        foreach ($purchases as $purchase) {
            DB::table('stock_purchases')
                ->where('id', $purchase->id)
                ->update([
                    'stock_type_data' => $purchase->stock_type ? Crypt::encryptString($purchase->stock_type) : null,
                    'purchase_price_data' => $purchase->purchase_price !== null ? Crypt::encryptString((string) $purchase->purchase_price) : null,
                    'quantity_data' => $purchase->quantity !== null ? Crypt::encryptString((string) $purchase->quantity) : null,
                    'unit_data' => $purchase->unit ? Crypt::encryptString($purchase->unit) : null,
                    'purchase_date_data' => $purchase->purchase_date ? Crypt::encryptString($purchase->purchase_date) : null,
                    'notes_data' => $purchase->notes ? Crypt::encryptString($purchase->notes) : null,
                ]);

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Data migration completed! ' . count($purchases) . ' records migrated.');

        return Command::SUCCESS;
    }
}
