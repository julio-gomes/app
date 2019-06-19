<?php
use Migrations\AbstractMigration;

class AddressesSellers extends AbstractMigration
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
        $this->table('addresses_sellers')
            ->addColumn('seller_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('address_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addIndex(
                [
                    'seller_id',
                ]
            )
            ->addIndex(
                [
                    'address_id',
                ]
            )
            ->create();

        $this->table('addresses_sellers')
            ->addForeignKey(
                'seller_id',
                'sellers',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'CASCADE',
                ]
            )
            ->addForeignKey(
                'address_id',
                'addresses',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'CASCADE',
                ]
            )
            ->update();
    }
}
