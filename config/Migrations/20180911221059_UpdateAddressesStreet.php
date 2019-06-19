<?php
use Migrations\AbstractMigration;

class UpdateAddressesStreet extends AbstractMigration
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
            ->changeColumn('street', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
            ])
            ->update();
    }
}
