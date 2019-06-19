<?php
use Migrations\AbstractMigration;

class UpdateAddress extends AbstractMigration
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
        $this->table('addresses')
            ->removeColumn('neighborhood')
            ->removeColumn('city')
            ->changeColumn('zip_code', 'string', [
                'default' => null,
                'limit' => 8,
                'null' => true,
            ])
            ->removeIndex(['zip_code'])
            ->addIndex(
                [
                    'zip_code',
                ],
                ['unique' => false]
            )
            ->addColumn('house_number', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('person_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])

            ->addForeignKey(
                'person_id',
                'persons',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'cascade',
                ]
            )
            ->addIndex(
                [
                    'person_id',
                ]
            )
            ->addColumn('city_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addForeignKey(
                'city_id',
                'cities',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'cascade',
                ]
            )
            ->addIndex(
                [
                    'city_id',
                ]
            )
            ->addColumn('district_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addForeignKey(
                'district_id',
                'districts',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'cascade',
                ]
            )
            ->addIndex(
                [
                    'district_id',
                ]
            )
            ->update();

        $this->table('addresses_sellers')
            ->drop()
            ->update();

        $this->table('persons')
            ->dropForeignKey('address_id')
            ->update();

    }
}
