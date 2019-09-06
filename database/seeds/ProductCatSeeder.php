<?php

use Illuminate\Database\Seeder;

class ProductCatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            {
                $pages = [
                    [
                        'title' => 'Product Categories',
                        'url' => 'product-category',
                        'created_at' => date('y-m-d h:i:s'),
                        'updated_at' => date('y-m-d h:i:s'),
                        'actions' => [
                            [
                                'title' => 'view',
                                'route' => 'product-category',
                                'method' => 'GET',
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s'),
                            ],
                            [
                                'title' => 'Create new product category',
                                'route' => 'product-category',
                                'method' => 'POST',
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s'),
                            ],
                            [
                                'title' => 'Edit product category',
                                'route' => 'product-category',
                                'method' => 'PUT',
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s'),
                            ],
                            [
                                'title' => 'Delete product category',
                                'route' => 'product-category/{vendor}',
                                'method' => 'DELETE',
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s'),
                            ],
                        ]
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
    }
}
