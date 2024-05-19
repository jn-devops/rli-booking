<?php

namespace RLI\Booking\Actions;

use RLI\Booking\Imports\Cornerstone\InventoriesImport;
use Lorisleiva\Actions\Concerns\AsAction;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;

class UploadInventoriesAction
{
    use AsAction;

    public string $commandSignature = 'upload:inventories {path}';
    public string $commandDescription = 'Import Inventories from an Excel file';
    public string $commandHelp = 'This command will upsert the records in the inventories table';
    public function handle(string $path): void
    {
        Excel::import(new InventoriesImport, $path);
    }

    public function asCommand(Command $command): void
    {
        $path = $command->argument('path');
        $this->handle($path);

        $command->info('Done!');
    }
}
