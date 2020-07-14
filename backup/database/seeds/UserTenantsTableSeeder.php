<?php

use App\Models\UserTenant;
use Illuminate\Database\Seeder;

class UserTenantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $workspace = Tenant::getTenant();
        factory(UserTenant::class)->create([
            'email' => "user1@{$workspace->prefix}.com"
        ]);
    }
}
