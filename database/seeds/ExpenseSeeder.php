<?php

use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
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
                'title' => 'Expenses',
                'url' => 'expenses',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'actions' => [
                    [
                        'title' => 'View',
                        'route' => 'expenses',
                        'method' => 'GET',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ],
                    [
                        'title' => 'Create new expenses',
                        'route' => 'expenses',
                        'method' => 'POST',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ],
                    [
                        'title' => 'Edit expense',
                        'route' => 'expenses/{expense}',
                        'method' => 'PUT',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ],
                    [
                        'title' => 'Edit expenses in bulk',
                        'route' => 'expenses/bulk-edit',
                        'method' => 'POST',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ],
                    [
                        'title' => 'Delete expenses',
                        'route' => 'expenses/{expense}',
                        'method' => 'DELETE',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ],
                    [
                        'title' => 'Delete expenses in bulk',
                        'route' => 'expenses/bulk-delete',
                        'method' => 'POST',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ],
                ],
            ],
            [
                'title' => 'Expense Category Management',
                'url' => 'expense-category',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'actions' => [
                    [
                        'title' => 'View',
                        'route' => 'expense-category',
                        'method' => 'GET',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ],
                    [
                        'title' => 'Create new expense category',
                        'route' => 'expense-category',
                        'method' => 'POST',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ],
                    [
                        'title' => 'Edit expense category',
                        'route' => 'expense-category/{expense}',
                        'method' => 'PUT',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ],
                    [
                        'title' => 'Edit expense category in bulk',
                        'route' => 'expense-category/bulk-edit',
                        'method' => 'POST',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ],
                    [
                        'title' => 'Delete expense category',
                        'route' => 'expense-category/{expense}',
                        'method' => 'DELETE',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ],
                    [
                        'title' => 'Delete expense category in bulk',
                        'route' => 'expense-category/bulk-delete',
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
