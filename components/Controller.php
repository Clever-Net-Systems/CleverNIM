<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 * ### CHANGES SHOULD BE REPLICATED IN THE FRONTEND
 */
class Controller extends RController {
	/**
	 * Filter out garbage requests
	 */
	public function init() {
		$uri = Yii::app()->request->requestUri;
		if (strpos($uri, 'favicon') || strpos($uri, 'robots')) {
			Yii::app()->end();
		}
	}

	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout = 'application.views.layouts.cchome';

	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu = array();

	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs = array();

	/**
	 * Generates menu items for main CMenu from DB
	 */
	public function getMenuItems($menu_id, $parent_id = null) {
		$results = Yii::app()->getDb()->createCommand();
		$results->select('item_id, label, url, icon, access, status')->from('menu_item');
		if ($parent_id === null)
			$results->where('menu_id=:mid AND parent_id IS NULL', array(':mid' => (int)$menu_id));
		else
			$results->where('menu_id=:mid AND parent_id=:pid', array(':mid' => (int)$menu_id, ':pid' => $parent_id));
		$results->order('sort_order ASC, label ASC');
		$results = $results->queryAll();
		$items = array();
		if (empty($results))
			return $items;
		foreach ($results as $result) {
			if ($result['status'] === "active") {
				$childItems = $this->getMenuItems($menu_id, $result['item_id']);
				$items[] = array(
					'template'       => ($parent_id === null ) ? ("<a href=\"#\"><span class=\"icon\"><img src=\"/images/ccimages/menu/" . $result['icon'] . "\"></span><span class=\"title\">" . $result['label'] . "</span></a>") : ("<a href=\"" . Yii::app()->createUrl($result['url']) . "\">" . $result['label'] . "</a>"),
					'label'          => $result['label'],
					'url'            => Yii::app()->createUrl($result['url']),
					'visible'        => Yii::app()->user->checkAccess($result['access']),
					'itemOptions'    => array('class' => ''),
					'linkOptions'    => array('class' => ''),
					'submenuOptions' => array(),
					'items'          => $childItems,
				);
			}
		}
		return $items;
	}

	/**
	 * Generates menu items for home CMenu from DB
	 */
	public function getHomeItems($menu_id, $parent_id = null) {
		$results = Yii::app()->getDb()->createCommand();
		$results->select('item_id, label, url, icon, access')->from('menu_item');
		if ($parent_id === null)
			$results->where('menu_id=:mid AND parent_id IS NULL', array(':mid' => (int)$menu_id));
		else
			$results->where('menu_id=:mid AND parent_id=:pid', array(':mid' => (int)$menu_id, ':pid' => $parent_id));
		$results->order('sort_order ASC, label ASC');
		$results = $results->queryAll();
		$items = array();
		if (empty($results))
			return $items;
		foreach ($results as $result) {
			$childItems = $this->getMenuItems($menu_id, $result['item_id']);
			$items[] = array(
				'template'       => ($parent_id === null ) ? ("<a href=\"" . Yii::app()->createUrl($result['url']) . "\"><span class=\"icon\"><img src=\"/images/ccimages/menu/" . $result['icon'] . "\"></span><span class=\"title\">" . $result['label'] . "</span></a>") : ("<a href=\"" . Yii::app()->createUrl($result['url']) . "\">" . $result['label'] . "</a>"),
				'label'          => $result['label'],
				'url'            => Yii::app()->createUrl($result['url']),
				'visible'        => Yii::app()->user->checkAccess($result['access']),
				'itemOptions'    => array('class' => ''),
				'linkOptions'    => array('class' => ''),
				'submenuOptions' => array(),
				'items'          => $childItems,
			);
		}
		return $items;
	}

	/**
	 * Update a single element with x-editable
	 */
	public function actionUpdateEditable() {
		if (Yii::app()->request->isAjaxRequest && isset($_POST['name']) && isset($_POST['value']) && isset($_POST['pk']) && isset($_POST['class'])) {
			$item = $_POST['class']::model()->findByPk($_POST['pk']);
			if ($item !== null) {
				$item[$_POST['name']] = $_POST['value'];
				return $item->save();
			} else {
				throw new CHttpException(404, Yii::t('app', 'Unable to find item.'));
			}
		} else {
			throw new CHttpException(400, Yii::t('app', 'Invalid request. Please do not repeat this request again.'));
		}
	}

	/**
	 * Deletes a particular model.
	 * If we need to recursively delete other objects, ask for confirmation
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id) {
		$model = $this->loadModel($id);
		// Recursively find objects to delete
		$objs = $model->cascadeDelete($model, false);
		if (count($objs) == 1) {
			if($model->delete()) {
				Yii::app()->user->setFlash('success', $model->_intname . " supprimé avec succès");
			} else {
				Yii::app()->user->setFlash('error', "Erreur lors de la suppression de " . $model->_intname);
			}
			$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'));
		} else {
			if (Yii::app()->user->checkAccess('CascadeDelete')) {
				if (Yii::app()->request->isPostRequest && isset($_POST['confirm'])) {
					// Reset cycle prevention array
					EZActiveRecord::$cascadedObjects = array();
					$model->cascadeDelete($model, true);
					$this->redirect(isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'));
				}
				if ($this->getModule()) {
					$viewname = str_replace($this->getModule()->name . "_", "", $model->getTableSchema()->name);
					$path = $this->getModule()->name . '.views.' . $viewname . '.delete';
				} else {
					$path = 'application.views.' . $model->getTableSchema()->name . '.delete';
				}
				$this->render($path, array(
					'model' => $model,
					'prevUri' => isset($_GET['prevUri']) ? $_GET['prevUri'] : array('admin'),
					'objs' => $objs,
				));
			} else {
				Yii::app()->user->setFlash('error', "La suppression de " . $model->_intname . " nécessite la suppression d'autres éléments en cascade et vous ne possédez pas les droits de suppression en cascade");
				$this->redirect(isset($_POST['prevUri']) ? $_POST['prevUri'] : array('admin'));
			}
		}
	}

}
