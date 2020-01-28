<?php

use Phinx\Migration\AbstractMigration;

class DailyFlow extends AbstractMigration
{
    public function change()
    {
        $this->table('daily_flow', ['collation' => 'utf8mb4_unicode_ci', 'signed' => false])
            ->addColumn('content', 'string', ['null' => true, 'default' => ''])
            ->addTimestamps()
            ->create();
    }
}
