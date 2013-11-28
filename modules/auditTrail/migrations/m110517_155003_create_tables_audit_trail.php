<?php

class m110517_155003_create_tables_audit_trail extends CDbMigration {

	/**
	 * Creates initial version of the audit trail table
	 */
	public function up()
	{
		$this->createTable('audit_trail',
			array(
				'id' => 'pk',
				'stamp' => 'datetime',
				'user_id' => 'integer',
				'action' => 'string',
				'class' => 'string',
				'class_id' => 'integer',
				'field' => 'string',
				'_intname' => 'string',
				'old_value' => 'string',
				'new_value' => 'string',
			)
		);

		$this->createIndex('idx_audit_trail_stamp', 'audit_trail', 'stamp');
		$this->createIndex('idx_audit_trail_user_id', 'audit_trail', 'user_id');
		$this->createIndex('idx_audit_trail_action', 'audit_trail', 'action');
		$this->createIndex('idx_audit_trail_class', 'audit_trail', 'class');
		$this->createIndex('idx_audit_trail_class_id', 'audit_trail', 'class_id');
		$this->createIndex('idx_audit_trail_field', 'audit_trail', 'field');
		$this->createIndex('idx_audit_trail_intname', 'audit_trail', '_intname');
		$this->createIndex('idx_audit_trail_old_value', 'audit_trail', 'old_value');
		$this->createIndex('idx_audit_trail_new_value', 'audit_trail', 'new_value');
	}

	/**
	 * Drops the audit trail table
	 */
	public function down()
	{
		$this->dropTable( 'audit_trail' );
	}

	/**
	 * Creates initial version of the audit trail table in a transaction-safe way.
	 * Uses $this->up to not duplicate code.
	 */
	public function safeUp()
	{
		$this->up();
	}

	/**
	 * Drops the audit trail table in a transaction-safe way.
	 * Uses $this->down to not duplicate code.
	 */
	public function safeDown()
	{
		$this->down();
	}
}
