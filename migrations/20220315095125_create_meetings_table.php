<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateMeetingsTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $table = $this->table('meetings');

        $table->addColumn('meetingName', 'string', array('limit' => 255))
            ->addColumn('meetingId', 'string', array('limit' => 255))
            ->addColumn('internalMeetingId', 'string', array('limit' => 255))
            ->addColumn('startTime', 'float')
            ->addColumn('createDate', 'string', array('limit' => 255))
            ->addColumn('running', 'string', array('limit' => 4))
            ->addColumn('createTime', 'float')
            ->addColumn('endTime', 'float')
            ->addColumn('duration', 'integer')
            ->addColumn('maxUsers', 'integer')
            ->create();
    }

    public function down()
    {
        $this->dropTable('meetings');
    }
}
