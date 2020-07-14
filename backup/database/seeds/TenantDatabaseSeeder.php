<?php

use App\Models\Workspace;
use Illuminate\Database\Seeder;

class TenantDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    { //db:seed --database=workspace1
        $connection = \DB::getDefaultConnection();
        $workspace = Workspace::where('prefix', $connection)->first();
        \Tenant::setTenant($workspace);
        $this->call(UserTenantsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
    }
}
