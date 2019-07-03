<?php
use Migrations\AbstractMigration;

class InterestFeedsUsers extends AbstractMigration
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

        $table = $this->table('interest_feeds_users');

        $table->addColumn('feed_id', 'integer', [
            'null' => false,
        ])
        ->addForeignKey('feed_id', 'feeds', 'id', array('delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'));

        $table->addColumn('user_id', 'integer', [
            'null' => false,
        ])
        ->addForeignKey('user_id', 'users', 'id', array('delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'));

        $table->create();
    }
}
