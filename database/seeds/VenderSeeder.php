<?php

use Illuminate\Database\Seeder;

class VenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = [
            [
                'title' => 'Vendors',
                'url' => 'vendor',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'actions' => [
                    [
                        'title' => 'View',
                        'route' => 'vendor',
                        'method' => 'GET',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ],
                    [
                        'title' => 'Create new Vendor',
                        'route' => 'addVendor',
                        'method' => 'POST',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ],
                    [
                        'title' => 'Edit Vendor',
                        'route' => 'edit/{vendor}',
                        'method' => 'PUT',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ],
                    [
                        'title' => 'Edit vendors in bulk',
                        'route' => 'vendors/bulk-edit',
                        'method' => 'POST',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ],
                    [
                        'title' => 'Delete Vendors',
                        'route' => 'deleteVendor/{vendor_id}',
                        'method' => 'DELETE',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ],
                    [
                        'title' => 'Delete Vendor in bulk',
                        'route' => 'vendors/bulk-delete',
                        'method' => 'POST',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ],
                ],
            ],
        ];
        // insert in pages and page_actions tables
        foreach ($pages as $page) {
            $arrayToInsert = $page;
            unset($arrayToInsert['actions']);
            $pageId = DB::table('pages')->insertGetId($arrayToInsert);

            foreach ($page['actions'] as $key => $action) {
                $page['actions'][$key]['page_id'] = $pageId;
            }
            DB::table('page_actions')->insert($page['actions']);
        }

        // allow super admin to access all the above actions
        $actions = DB::table('page_actions')->get();
        $pivotRecords = [];
        foreach ($actions as $action) {
            $pivotRecords[] = [
                'user_role_id' => 1,
                'page_action_id' => $action->id,
            ];
        }
        DB::table('user_role_page_action')->insert($pivotRecords);
    }
}

