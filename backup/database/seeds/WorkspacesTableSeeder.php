<?php

use App\Models\Workspace;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class WorkspacesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 5) as $value) {
            Workspace::create([
                'name' => "Workspace $value",
                'database' => "tenant_".Str::random(16),
                'prefix' => "workspace$value"
            ]);
        }
    }
}
