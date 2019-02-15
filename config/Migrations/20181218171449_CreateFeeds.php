<?php
use Migrations\AbstractMigration;

class CreateFeeds extends AbstractMigration
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
            'null' => false,
        ]);
        $table->addColumn('textpublish', 'string', [
            'default' => null,
            'limit' => 50,
            'null' => true,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->create();
    }
}
