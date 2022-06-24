<?php

namespace Spatie\SidecarShiki\Commands;

use Hammerstone\Sidecar\Commands\Deploy;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Spatie\SidecarShiki\Functions\HighlightFunction;

/** @internal */
class InternalShikiSetupCommand extends Command
{
    public $signature = 'sidecar-shiki:setup';

    public $description = 'Deploy and activate ShikiLambda function to AWS. (Only used for local testing purposes)';

    protected $hidden = true;

    public function handle(): int
    {
        $region = env('SIDECAR_REGION');
        $bucket = env('SIDECAR_ARTIFACT_BUCKET_NAME');

        config()->set('sidecar.functions', [HighlightFunction::class]);
        config()->set('sidecar.env', 'testing');
        config()->set('sidecar.aws_key', env('SIDECAR_ACCESS_KEY_ID'));
        config()->set('sidecar.aws_secret', env('SIDECAR_SECRET_ACCESS_KEY'));
        config()->set('sidecar.aws_region', $region);
        config()->set('sidecar.aws_bucket', $bucket);
        config()->set('sidecar.execution_role', env('SIDECAR_EXECUTION_ROLE'));

        $deploy = $this->confirm("Deploy Lambda function to {$region} and bucket {$bucket}?", true);
        $this->info("Deploying Lambda function to {$region} and bucket {$bucket}.");

        if (! $deploy) {
            $this->info('Nothing deployed.');

            return self::SUCCESS;
        }

        $this->info('Deploy function …');

        Artisan::call(Deploy::class, [
            '--activate' => true,
            '--env' => 'testing',
        ]);

        $this->comment('All done');

        return self::SUCCESS;
    }
}
