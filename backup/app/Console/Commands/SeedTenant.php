<?php

namespace App\Console\Commands;

use App\Models\Workspace;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SeedTenant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate tenant for test';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (Schema::hasTable((new Workspace())->getTable())) {
            $companies = Workspace::all();
            foreach ($companies as $workspace) {
                DB::statement("DROP DATABASE IF EXISTS {$workspace->database};");
            }
            $this->info('Tenant database dropped');
        }

        $this->info('Seeding system');
        $this->call('migrate:fresh', [
            '--database' => 'system',
            '--path' => 'database/migrations/system'
        ]);
        $this->call('db:seed', [
            '--class' => 'SystemDatabaseSeeder'
        ]);
        \Tenant::loadConnections();
        $this->info('Seeding system finished');

        $companies = Workspace::all();
        $this->call('tenant:create', [
            '--ids' => implode(",", $companies->pluck('id')->toArray()),
        ]);
        foreach ($companies as $workspace){
            $this->call('db:seed', [
                '--database' => $workspace->prefix,
                '--class' => 'TenantDatabaseSeeder'
            ]);
        }

    }
}
