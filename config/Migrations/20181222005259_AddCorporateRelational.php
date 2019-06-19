<?php
use Migrations\AbstractMigration;

class AddCorporateRelational extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $this->table('corporates_product_categories', ['id' => false, 'primary_key' => ['product_category_id', 'corporate_id']])
        ->addColumn('product_category_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ])
        ->addColumn('corporate_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ])
        ->addIndex(
            [
                'product_category_id',
            ]
        )
        ->addIndex(
            [
                'corporate_id',
            ]
        )
        ->create();

        $this->table('corporates_product_categories')
            ->addForeignKey(
                'product_category_id',
                'product_categories',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'corporate_id',
                'corporates',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

            $this->table('corporates_brands', ['id' => false, 'primary_key' => ['brand_id', 'corporate_id']])
            ->addColumn('brand_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('corporate_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addIndex(
                [
                    'brand_id',
                ]
            )
            ->addIndex(
                [
                    'corporate_id',
                ]
            )
            ->create();

        $this->table('corporates_brands')
            ->addForeignKey(
                'brand_id',
                'brands',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'corporate_id',
                'corporates',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

        $this->table('branch_of_activities_corporates', ['id' => false, 'primary_key' => ['branch_of_activity_id', 'corporate_id']])
            ->addColumn('branch_of_activity_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('corporate_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addIndex(
                [
                    'branch_of_activity_id',
                ]
            )
            ->addIndex(
                [
                    'corporate_id',
                ]
            )
            ->create();

        $this->table('branch_of_activities_corporates')
            ->addForeignKey(
                'branch_of_activity_id',
                'branch_of_activities',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->addForeignKey(
                'corporate_id',
                'corporates',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->update();
    }
}
