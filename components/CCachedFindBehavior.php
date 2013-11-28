<?php
/**
 * CCachedFindBehavior class file.
 *
 * @author ezwebapp.com <info@ezwebapp.com>
 * @link http://www.ezwebapp.com/
 * @version 0.1
 */

/**
 * The CCachedFindBehavior extension adds native caching capabilities to your
 * active records. It requires the use of a TIMESTAMP column in your tables.
 */

/* The CAdvancedArBehavior extension adds up some functionality to the default
 * possibilites of yii´s ActiveRecord implementation.
 *
 * To use this extension, just copy this file to your extensions/ directory,
 * add 'import' => 'application.extensions.CAdvancedArBehavior', [...] to your 
 * config/main.php and add this behavior to each model you would like to
 * inherit the new possibilities:
 *
 * public function behaviors(){
 *         return array( 'CAdvancedArBehavior' => array(
 *        	 'class' => 'application.extensions.CAdvancedArBehavior')); 
 *         }                                  
 *
 *
 * Automatically sync your Database Schema when setting new fields by
 * activating $syncdb
 *
 * Better support of MANY_TO_MANY relations:
 *
 * When we have defined a MANY_MANY relation in our relations() function, we
 * are now able to add up instances of the foreign Model on the fly while
 * saving our Model to the Database. Let´s assume the following Relation:
 *
 * Post has:
 *  'categories'=>array(self::MANY_MANY, 'Category',
 *                  'tbl_post_category(post_id, category_id)')
 *
 * Category has:
 * 'posts'=>array(self::MANY_MANY, 'Post',
 *                  'tbl_post_category(category_id, post_id)')
 *
 * Now we can use the attribute 'categories' of our Post model to add up new
 * rows to our MANY_MANY connection Table:
 *
 * $post = new Post();
 * $post->categories = Category::model()->findAll();
 * $post->save();
 *
 * This will save our new Post in the table Post, and in addition to this it
 * updates our N:M-Table with every Category available in the Database.
 * 
 * We can further limit the Objects given to the attribute, and can also go 
 * the other Way around:
 *
 * $category = new Category();
 * $category->posts = array(5, 6, 7, 10);
 * $caregory->save(); 
 *
 * We can pass Object instances like in the first example, or a list of
 * integers that representates the Primary key of the Foreign Table, so that
 * the Posts with the id 5, 6, 7 and 10 get´s added up to our new Category.
 *
 * 5 Queries will be performed here, one for the Category-Model and four for
 * the N:M-Table tbl_post_category. Note that this behavior could be tuned
 * further in the future, so only one query get´s executed for the MANY_MANY
 * Table.
 *
 * We can also pass a _single_ object or an single integer:
 *
 * $category = new Category();
 * $category->posts = Post::model()->findByPk(12);
 * $category->posts = 12;
 * $category->save();
 * 
 * Assign -1 to a attribute to let it be untouched by the behavior.
 */

class CCachedFindBehavior extends CActiveRecordBehavior {
	/**
	 * Use a global state to say that a table has been modified
	 */
	public function beforeSave() {
		Yii::app()->setGlobalState('cf_' . $this->owner->tableName(), time());
	}

	/* Extracts list of tables from with attribute. TODO handle scopes */
	public function getTableList($with) {
		if (is_string($with)) {
			return explode('.', $with);
		} else {
			$tables = array();
			foreach ($with as $k => $v) {
				if (is_string($v)) {
					$tables[] = $v;
				} else if (is_string($k) && is_array($v)) {
					$tables = $tables + $this->getTableList($k);
				}
			}
			return $tables;
		}
	}

	/**
	 * Cache all find() requests on the condition that the tables have not been updated
	 */
	public function beforeFind() {
		$with = $this->owner->dbCriteria->with;
		if ($with === null) {
			$dep = new CGlobalStateCacheDependency("cf_" . $this->owner->tableName());
			$this->owner->cache(1000, $dep, 1);
		} else {
			$deptables = $this->getTableList($with);
			$dep = new CChainedCacheDependency();
			$dep->dependencies[] = new CGlobalStateCacheDependency("cf_" . $this->owner->tableName());
			foreach ($deptables as $t) {
				$dep->dependencies[] = new CGlobalStateCacheDependency("cf" . $t);
			}
			$this->owner->cache(1000, $dep, 1);
		}
	}
}
