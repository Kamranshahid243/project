<?php

use Illuminate\Database\Seeder;

class ShopsMenuSeeder extends Seeder
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
                'title' => 'Shops',
                'url' => 'shops',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'actions' => [
                    [
                        'title' => 'View',
                        'route' => 'shops',
                        'method' => 'GET',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ],
                    [
                        'title' => 'Create new shop',
                        'route' => 'shops',
                        'method' => 'POST',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ],
                    [
                        'title' => 'Edit shop',
                        'route' => 'shops/{shop}',
                        'method' => 'PUT',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ],
                    [
                        'title' => 'Edit shops in bulk',
                        'route' => 'shops/bulk-edit',
                        'method' => 'POST',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ],
                    [
                        'title' => 'Delete shop',
                        'route' => 'shops/{shop}',
                        'method' => 'DELETE',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ],
                    [
                        'title' => 'Delete shops in bulk',
                        'route' => 'shops/bulk-delete',
                        'method' => 'POST',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ],
                ],
            ],
        ];

        // insert in pages and page_actions tables
        foreach ( $pages as $page ) {
            $arrayToInsert = $page;
            unset($arrayToInsert['actions']);
            $pageId = DB::table('pages')->insertGetId($arrayToInsert);

            foreach ( $page['actions'] as $key => $action ){
                $page['actions'][$key]['page_id'] = $pageId;
            }
            DB::table('page_actions')->insert($page['actions']);
        }

        // allow super admin to access all the above actions
        $actions = DB::table('page_actions')->get();
        $pivotRecords = [];
        foreach ( $actions as $action ){
            $pivotRecords[] = [
                'user_role_id' => 1,
                'page_action_id' => $action->id,
            ];
        }
        DB::table('user_role_page_action')->insert($pivotRecords);
    }
}