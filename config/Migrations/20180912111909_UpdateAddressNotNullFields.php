<?php
use Migrations\AbstractMigration;

class UpdateAddressNotNullFields extends AbstractMigration
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
        $this->table('persons')
            ->changeColumn('company_name', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
            ])
            ->changeColumn('cnpj', 'string', [
                    'default' => null,
                    'limit' => 45,
                    'null' => true,
            ])
            ->update();
    }
}
