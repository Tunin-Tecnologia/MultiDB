<?php
declare(strict_types=1);

namespace App\Tenant;


use App\Models\Workspace;
use Illuminate\Support\Facades\Schema;

class TenantManager
{
    private $tenant;

    /**
     * @return Workspace
     */
    public function getTenant(): ?Workspace
    {
        return $this->tenant;
    }

    /**
     * @param Workspace $tenant
     */
    public function setTenant(?Workspace $tenant): void
    {
        $this->tenant = $tenant;
        $this->makeTenantConnection();
    }

    private function makeTenantConnection()
    {
        $clone = config('database.connections.system');
        $clone['database'] = $this->tenant->database;
        \Config::set('database.connections.tenant', $clone);
        \DB::reconnect('tenant');
    }

    public function loadConnections()
    {
        if (Schema::hasTable((new Workspace())->getTable())) {
            $companies = Workspace::all();
            foreach ($companies as $workspace) {
                $clone = config('database.connections.system');
                $clone['database'] = $workspace->database;
                \Config::set("database.connections.{$workspace->prefix}", $clone); //workspace1
            }
        }
    }

    public function isTenantRequest(){
        return !\Request::is('system/*') && \Request::route('prefix');
    }
}
