<?php
use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class Initial extends AbstractMigration
{
    public function up()
    {

        $this->table('addresses')
            ->addColumn('zip_code', 'string', [
                'default' => null,
                'limit' => 8,
                'null' => false,
            ])
            ->addColumn('street', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('neighborhood', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('city', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('complement', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('state_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addIndex(
                [
                    'zip_code',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'state_id',
                ]
            )
            ->addIndex(
                [
                    'city',
                ]
            )
            ->create();

        $this->table('branch_of_activities')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => false,
            ])
            ->create();

        $this->table('branch_of_activities_buyers', ['id' => false, 'primary_key' => ['branch_of_activity_id', 'buyer_id']])
            ->addColumn('branch_of_activity_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('buyer_id', 'integer', [
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
                    'buyer_id',
                ]
            )
            ->create();

        $this->table('brands')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => false,
            ])
            ->create();

        $this->table('buyers')
            ->create();

        $this->table('occupation_areas')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => false,
            ])
            ->addColumn('latitude', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 10,
                'scale' => 8,
            ])
            ->addColumn('longitude', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 11,
                'scale' => 8,
            ])
            ->addColumn('seller_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->create();

        $this->table('persons')
            ->addColumn('company_name', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('cnpj', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('telephone', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('house_number', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('address_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('latitude', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 10,
                'scale' => 8,
            ])
            ->addColumn('longitude', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 11,
                'scale' => 8,
            ])
            ->addIndex(
                [
                    'address_id',
                ]
            )
            ->create();

        $this->table('product_categories')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => false,
            ])
            ->create();

        $this->table('sellers')
            ->create();

        $this->table('sellers_brands', ['id' => false, 'primary_key' => ['brand_id', 'seller_id']])
            ->addColumn('brand_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('seller_id', 'integer', [
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
                    'seller_id',
                ]
            )
            ->create();

        $this->table('sellers_product_categories', ['id' => false, 'primary_key' => ['product_category_id', 'seller_id']])
            ->addColumn('product_category_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('seller_id', 'integer', [
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
                    'seller_id',
                ]
            )
            ->create();

        $this->table('states')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => false,
            ])
            ->addColumn('initials', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => false,
            ])
            ->addIndex(
                [
                    'name',
                ]
            )
            ->addIndex(
                [
                    'initials',
                ]
            )
            ->create();

        $this->table('users')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => false,
            ])
            ->addColumn('email', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => false,
            ])
            ->addColumn('password', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('cellphone', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('avatar_base64', 'string', [
                'default' => null,
                'limit' => 2500,
                'null' => true,
            ])
            ->addColumn('avatar_mime_type', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addIndex(
                [
                    'email',
                ],
                ['unique' => true]
            )
            ->create();

        $this->table('users_has_users', ['id' => false, 'primary_key' => ['user_id', 'friend_id']])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('friend_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('status', 'integer', [
                'comment' => '0 = recusado
                    1 = aceito
                    2 = pendente',
                'default' => '2',
                'limit' => MysqlAdapter::INT_TINY,
                'null' => false,
            ])
            ->addIndex(
                [
                    'friend_id',
                ]
            )
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->create();

        $this->table('addresses')
            ->addForeignKey(
                'state_id',
                'states',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->update();

        $this->table('buyers')
            ->addForeignKey(
                'id',
                'persons',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->update();

        $this->table('occupation_areas')
            ->addForeignKey(
                'id',
                'sellers',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->update();

        $this->table('persons')
            ->addForeignKey(
                'address_id',
                'addresses',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->update();

        $this->table('sellers')
            ->addForeignKey(
                'id',
                'persons',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->update();

        $this->table('sellers_brands')
            ->addForeignKey(
                'brand_id',
                'brands',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->addForeignKey(
                'seller_id',
                'sellers',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->update();

        $this->table('sellers_product_categories')
            ->addForeignKey(
                'product_category_id',
                'product_categories',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->addForeignKey(
                'seller_id',
                'sellers',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->update();

        $this->table('users_has_users')
            ->addForeignKey(
                'friend_id',
                'users',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->update();
    }

    public function down()
    {
        $this->table('addresses')
            ->dropForeignKey(
                'state_id'
            )->save();

        $this->table('buyers')
            ->dropForeignKey(
                'id'
            )->save();

        $this->table('occupation_areas')
            ->dropForeignKey(
                'id'
            )->save();

        $this->table('persons')
            ->dropForeignKey(
                'address_id'
            )->save();

        $this->table('sellers')
            ->dropForeignKey(
                'id'
            )->save();

        $this->table('sellers_brands')
            ->dropForeignKey(
                'brand_id'
            )
            ->dropForeignKey(
                'seller_id'
            )->save();

        $this->table('sellers_product_categories')
            ->dropForeignKey(
                'product_category_id'
            )
            ->dropForeignKey(
                'seller_id'
            )->save();

        $this->table('users_has_users')
            ->dropForeignKey(
                'friend_id'
            )
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('addresses')->drop()->save();
        $this->table('branch_of_activities')->drop()->save();
        $this->table('branch_of_activities_buyers')->drop()->save();
        $this->table('brands')->drop()->save();
        $this->table('buyers')->drop()->save();
        $this->table('occupation_areas')->drop()->save();
        $this->table('persons')->drop()->save();
        $this->table('product_categories')->drop()->save();
        $this->table('sellers')->drop()->save();
        $this->table('sellers_brands')->drop()->save();
        $this->table('sellers_product_categories')->drop()->save();
        $this->table('states')->drop()->save();
        $this->table('users')->drop()->save();
        $this->table('users_has_users')->drop()->save();
    }
}
