<?php

namespace App\Jobs\Duo;

use App\Environment;
use App\Helpers\DuoSecurity;
use App\Models\Directory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteUserInDuo implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /*
     * The Directory
     *
     * @var $directory
     */
    protected $directory;

    /*
     * The unique Identifier of the user in DUO Mobile
     */
    protected $duoId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Directory $directory, $duoId)
    {
        $this->directory = $directory;
        $this->duoId = $duoId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!Environment::shouldExecute()) {
            return;
        }

        // Create the DUO Client
        $duoClient = new DuoSecurity\Client(
            $this->directory->duo_integration_key,
            $this->directory->duo_secret_key,
            $this->directory->duo_api_url,
        );

        // Get all phones assigned to user in DUO Mobile
        $response = $duoClient->jsonApiCall('GET', '/admin/v1/users/' . $this->duoId . '/phones', [
            'limit'  => 100,
            'offset' => 0,
        ]);

        // Remove all phones from the user and delete them
        $phones = $response['response']['response'] ?? [];
        foreach ($phones as $phone) {
            $duoClient->jsonApiCall('DELETE', '/admin/v1/users/' . $this->duoId . '/phones/' . $phone['phone_id'], []);
            $duoClient->jsonApiCall('DELETE', '/admin/v1/phones/' . $phone['phone_id'], []);
        }

        // Delete the user in DUO Mobile
        $duoClient->jsonApiCall('DELETE', '/admin/v1/users/' . $this->duoId, []);
    }
}
