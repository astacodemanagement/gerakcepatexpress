<?php

namespace App\Console\Commands;

use Symfony\Component\Process\Process;
use Illuminate\Console\Command;
use Spatie\Backup\BackupDestination\BackupDestinationFactory;
use Spatie\Backup\BackupFacade;

class BackupDatabaseCommand extends Command
{
    /**
     * The name and signature of the command.
     *
     * @var string
     */
    protected $signature = 'backup:database';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Melakukan backup database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Memulai proses backup database...');

        // Buat konfigurasi backup
        $backupConfig = BackupFacade::config();

        // Pilih destination
        $destination = BackupDestinationFactory::create('local');

        // Jalankan backup
        BackupFacade::backup($destination, $backupConfig);

        $this->info('Backup database berhasil!');

        return 0;
    }
}
