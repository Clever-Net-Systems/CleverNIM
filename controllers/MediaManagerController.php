<?php

class MediaManagerController extends Controller {
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = 'application.views.layouts.cchome';

	/**
	 * jqueryfileupload backend
	 */
	public function actionJqueryfileupload() {
		require('UploadHandler.php');
		if (!isset($_GET['obj']) || !isset($_GET['id'])) {
			throw new CHttpException(500, Yii::t('app', 'Invalid call. Please do not repeat this action.'));
		}
		$upload_dir = DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . $_GET['obj'] . DIRECTORY_SEPARATOR . $_GET['id'] . DIRECTORY_SEPARATOR;
		$upload_handler = new UploadHandler(array(
			'upload_dir' => dirname(Yii::app()->request->scriptFile) . $upload_dir,
			'upload_url' => Yii::app()->createUrl($upload_dir) . DIRECTORY_SEPARATOR,
		));
	}

	/**
	 * elFinder backend options
	 */
	private $elFinderOpts = array(
		'root'         => '',           // Will be filled in upon instanciation
		'URL'          => '',           // Will be filled in upon instanciation
		'rootAlias'    => 'Media',      // display this instead of root directory name
		'disabled'     => array(),      // list of not allowed commands
		'dotFiles'     => false,        // display dot files
		'dirSize'      => true,         // count total directories sizes
		'fileMode'     => 0644,         // new files mode
		'dirMode'      => 0755,         // new folders mode
		'mimeDetect'   => 'mime_content_type',      // files mimetypes detection method (finfo, mime_content_type, linux (file -ib), bsd (file -Ib), internal (by extensions))
		'uploadAllow'  => array('all'), // mimetypes which allowed to upload
		'uploadDeny'   => array(),      // mimetypes which not allowed to upload
		'uploadOrder'  => 'deny,allow', // order to proccess uploadAllow and uploadAllow options
		'imgLib'       => 'gd',         // image manipulation library (imagick, mogrify, gd)
		'tmbDir'       => '.tmb',       // directory name for image thumbnails. Set to "" to avoid thumbnails generation
		'tmbCleanProb' => 1,            // how frequiently clean thumbnails dir (0 - never, 100 - every init request)
		'tmbAtOnce'    => 5,            // number of thumbnails to generate per request
		'tmbSize'      => 48,           // images thumbnails size (px)
		'fileURL'      => true,         // display file URL in "get info"
		'dateFormat'   => 'j M Y H:i',  // file modification date format
		// 'logger'       => null,      // object logger
		// 'defaults'     => array(     // default permisions
		//      'read'   => true,
		//      'write'  => true,
		//      'rm'     => true
		//      ),
		// 'perms'        => array(),      // individual folders/files permisions    
		'debug'        => false,         // send debug to client
		// 'archiveMimes' => array(),      // allowed archive's mimetypes to create. Leave empty for all available types.
		// 'archivers'    => array()       // info about archivers to use. See example below. Leave empty for auto detect
		// 'archivers' => array(
		//      'create' => array(
		//              'application/x-gzip' => array(
		//                      'cmd' => 'tar',
		//                      'argc' => '-czf',
		//                      'ext'  => 'tar.gz'
		//                      )
		//              ),
		//      'extract' => array(
		//              'application/x-gzip' => array(
		//                      'cmd'  => 'tar',
		//                      'argc' => '-xzf',
		//                      'ext'  => 'tar.gz'
		//                      ),
		//              'application/x-bzip2' => array(
		//                      'cmd'  => 'tar',
		//                      'argc' => '-xjf',
		//                      'ext'  => 'tar.bz'
		//                      )
		//              )
		//      )
	);

	/**
	 * Filters
	 */
	public function filters() {
		return array(
			'rights'
		);
	}

	/**
	 * @var string the default controller action
	 */
	public $defaultAction = 'index';

	/**
	 * Static class method for retrieveing thumbnail name
	 */
	static public function getTmb($file) {
		$file = substr($file, 6);
		if ($file && ($file[0] == '/')) {
			$file = substr($file, 1);
		}
		return md5(Yii::app()->basePath . DIRECTORY_SEPARATOR . "media" . DIRECTORY_SEPARATOR . $file) . '.png';
	}

	/**
	 * Thumbnail finder for FileTree
	 */
	public function actionGetTmb() {
		if (Yii::app()->request->isAjaxRequest && isset($_POST['file'])) {
			$file = $_POST['file'];
			if ($file && ($file[0] == '/')) {
				$file = substr($file, 1);
			}
			echo md5(Yii::app()->basePath . DIRECTORY_SEPARATOR . "media" . DIRECTORY_SEPARATOR . $file) . '.png';
			Yii::app()->end();
		} else {
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
		}
	}

	/**
	 * elFinder backend connector
	 */
	public function actionMmconnector() {
		$this->elFinderOpts['root'] = Yii::app()->basePath . DIRECTORY_SEPARATOR . "media";
		$this->elFinderOpts['URL'] = Yii::app()->createAbsoluteUrl("media") . "/";
		$fm = new elFinder($this->elFinderOpts);
		$fm->run();
	}

	/**
	 * jqueryFileTree backend connector
	 */
	public function actionFtConnector() {
		$root = Yii::app()->basePath . DIRECTORY_SEPARATOR . "media";
		$_POST['dir'] = urldecode($_POST['dir']);
		if( file_exists($root . $_POST['dir']) ) {
			$files = scandir($root . $_POST['dir']);
			natcasesort($files);
			if( count($files) > 2 ) { /* The 2 accounts for . and .. */
				echo "<ul class=\"jqueryFileTree\" style=\"display: none;\">";
				// All dirs
				foreach( $files as $file ) {
					if( file_exists($root . $_POST['dir'] . $file) && $file != '.' && $file != '..' && is_dir($root . $_POST['dir'] . $file) && $file != '.tmb') {
						echo "<li class=\"directory collapsed\"><a href=\"#\" rel=\"" . htmlentities($_POST['dir'] . $file) . "/\">" . htmlentities($file) . "</a></li>";
					}
				}
				// All files
				foreach( $files as $file ) {
					if( file_exists($root . $_POST['dir'] . $file) && $file != '.' && $file != '..' && !is_dir($root . $_POST['dir'] . $file) ) {
						$ext = preg_replace('/^.*\./', '', $file);
						echo "<li class=\"file ext_$ext\"><a href=\"#\" rel=\"" . htmlentities($_POST['dir'] . $file) . "\">" . htmlentities($file) . "</a></li>";
					}
				}
				echo "</ul>";	
			}
		}
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex() {
		$this->render('application.views.mediamanager.mediamanager');
	}
}
