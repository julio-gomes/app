<?php
use Migrations\AbstractMigration;

class AddEmailToPersons extends AbstractMigration
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
        $table = $this->table('persons');
        $table->addColumn('email', 'string', [
            'default' => null,
            'limit' => 50,
            'null' => true,
        ]);
        $table->update();
    }
}
