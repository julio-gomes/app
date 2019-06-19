<?php
use Migrations\AbstractMigration;

class AddPictureFeed extends AbstractMigration
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
        $table = $this->table('feeds');

        $table->addColumn('picture', 'text', [
            'default' => null,
            'null' => true,
        ])
        ->save();
    }
}
