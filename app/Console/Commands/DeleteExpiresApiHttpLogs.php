<?php

namespace App\Console\Commands;

use App\Models\ApiHttpLog;
use Illuminate\Console\Command;

class DeleteExpiresApiHttpLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api-http-log:delete-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete expired API HTTP Logs';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $expiredApiHttpLogs = ApiHttpLog::select('id')
            ->where('expires_at', '<', now())
            ->get();

        // Delete expired API HTTP Logs
        foreach ($expiredApiHttpLogs as $expiredApiHttpLog) {
            $expiredApiHttpLog->delete();
        }

        return 0;
    }
}
