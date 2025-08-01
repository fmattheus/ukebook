<?php

/**
 * a "lite" MVC-ish Controller
 *
 * @class Ugs
 * @namespace ugsPhp
 */
class Ugs{

	/**
	 * Boostraps and runs the entire danged system!
	 */
	function __construct() {
		$this->Bootstrap();

		// Reads query param to pick appropriate Actions
		$action = isset( $_GET['action'] ) ? Actions::ToEnum( $_GET['action'] ) : Actions::Songbook;

		$user = $this->DoAuthenticate( $action );
		if ( !$user->IsAllowAccess  ) {
				return;
			}

		$builder = $this->GetBuilder( $action, $user );
		$model = $builder->Build();

		// all done, time to render
		if ( $model->IsJson ) {
			$this->RenderJson( $model );
		}
		else {
			$model->SiteUser = $user;
			$this->RenderView( $model, $action );
		}
	}

	/**
	 * Renders View associated with Action, making only $model available on the page
	 *
	 * @param [ViewModel] $model  appropriate view model entity
	 * @param [Actions(int)] $action
	 */
	private function RenderView( $model, $action ) {
		header('X-Powered-By: ' . Config::PoweredBy);
		include_once Config::$AppDirectory . 'views/' . $this->GetViewName( $action );
	}


	/**
	 * Emits serilized JSON version of the $model with appropriate headers
	 *
	 * @param unknown $model
	 */
	private function RenderJson( $model ) {
		header( 'Content-Type: application/json' );
		if ( isset( $model->HasErrors ) && $model->HasErrors ) {
			header( 'HTTP/1.1 500' );
		}
		unset($model->IsJson);
		echo json_encode( $model );
	}

	/**
	 * returns initialized SiteUser object, check the "Is Allow Access" property.
	 * This method MAY hijack flow controlby performing a recirect
	 * or by rendering an alternate view
	 *
	 * @param Actions(enum) $action
	 * @return SiteUser
	 */
	private function DoAuthenticate( $action ) {

		if ( (! Config::IsLoginRequired ) || ( $action == Actions::Reindex ) ) {
			$user = new SiteUser();
			$user->IsAllowAccess = true;
			return  $user;
		}

		$login = new SimpleLogin();

		if ($action == Actions::Logout){
			$login->Logout();
			header('Location: ' . self::MakeUri(Actions::Login));
			return  $login->GetUser();
		}

		$user = $login->GetUser();
		if ( !$user->IsAllowAccess ) {
			// User is not logged in.
			// If this is not a login attempt, redirect to the login page.
			$isLoginAttempt = ($action == Actions::Login);
			if (!$isLoginAttempt) {
				$redirectUrl = $_SERVER['REQUEST_URI'];
				$loginUrl = self::MakeUri(Actions::Login);
				$separator = (strpos($loginUrl, '?') === false) ? '?' : '&';
				header('Location: ' . $loginUrl . $separator . 'redirect=' . urlencode($redirectUrl));
				return $user;
			}

			$builder = $this->GetBuilder( Actions::Login, $user );
			$model = $builder->Build($login);
			$user = $login->GetUser();

			// during form post the builder automatically attempts a login -- let's check whether that succeeded...
			if ( !$user->IsAllowAccess ) {
				$this->RenderView( $model, Actions::Login );
				return  $user;
			}

			// successful login we redirect:
			$redirectUrl = isset($_POST['redirect']) && !empty($_POST['redirect']) ? $_POST['redirect'] : self::MakeUri(Actions::Songbook);
			header('Location: ' . $redirectUrl);
			return  $user;
		}
		elseif ($action == Actions::Login){
			// if for some reason visitor is already logged in but attempting to view the Login page, redirect:
			header( 'Location: ' . self::MakeUri( Actions::Songbook ) );
			return $user;
		}

		// Check if action requires admin access
		$adminActions = array(
			Actions::Setlist,
			Actions::SaveSetlist,
			Actions::ListSetlists,
			Actions::DeleteSetlist,
			Actions::CreatePDF,
			Actions::ListPDFs,
			Actions::DownloadPDF,
			Actions::StartSetlist,
			Actions::ImportSpreadsheet
		);
		
		if (in_array($action, $adminActions) && !$user->IsAdmin) {
			// Redirect non-admin users to songbook with error message
			header('Location: ' . self::MakeUri(Actions::Songbook) . '&error=admin_required');
			return $user;
		}

		// $user->IsAllowAccess = true;
		return $user;
	}

	/**
	 * Returns instance of appropriate Builder class
	 *
	 * @param ActionEnum $action desired action
	 * @param SiteUser $siteUser current visitor
	 * @return ViewModelBuilder-Object (Instantiated class)
	 */
	private function GetBuilder( $action, $siteUser ) {
		$builder = null;

		switch($action){
			case Actions::Edit:
			case Actions::Song:
				$builder = new Song_Vmb();
				break;
			case Actions::Source:
				$builder = new Source_Vmb();
				break;
			case Actions::Reindex:
				$builder = new RebuildSongCache_Vmb();
				break;
			case Actions::Logout:
			case Actions::Login:
				$builder = new Login_Vmb();
				break;
        		case Actions::AjaxNewSong:
	        		$builder = new Ajax_NewSong_Vmb();
		        	break;
        		case Actions::AjaxUpdateSong:
	        		$builder = new Ajax_UpdateSong_Vmb();
		        	break;
			case Actions::Setlist:
				$builder = new Setlist_Vmb();
				break;
			case Actions::SaveSetlist:
				$builder = new SaveSetlist_Vmb();
				break;
			case Actions::ListSetlists:
				$builder = new SetlistList_Vmb();
				break;
			case Actions::DeleteSetlist:
				$builder = new DeleteSetlist_Vmb();
				break;
			case Actions::CreatePDF:
				$builder = new CreatePDF_Vmb();
				break;
			case Actions::ListPDFs:
				$builder = new ListPDFs_Vmb();
				break;
			case Actions::DownloadPDF:
				$builder = new DownloadPDF_Vmb();
				break;
			case Actions::StartSetlist:
				$builder = new StartSetlist_Vmb();
				break;
			case Actions::ImportSpreadsheet:
				$builder = new ImportSpreadsheet_Vmb();
				break;
		        default:
        			$builder = Config::UseDetailedLists
					? new SongListDetailed_Vmb()
					: new SongList_Vmb();
				break;
		}

		$builder->SiteUser = $siteUser;
		return $builder;
	}

	/**
	 * Bootstraps UGS...
	 * > Instantiates configs class
	 * > Automatically includes ALL of the PHP classes in these directories: "classes" and "viewmodels".
	 * This is a naive approach, see not about including base classes first.
	 *
	 * @private
	 */
	private function Bootstrap() {
		// let's get Config setup
		$appRoot = dirname(__FILE__);
		include_once $appRoot . '/Config.php';

		// some dependencies: make sure base classes are included first...
		include_once $appRoot . '/classes/SiteUser.php';
		include_once $appRoot . '/viewmodels/_base_Vm.php';
		include_once $appRoot . '/builders/_base_Vmb.php';

		Config::Init();

		foreach (array('classes', 'viewmodels', 'builders') as $directory) {
			foreach (glob($appRoot . '/' . $directory . '/*.php') as $filename) {
				include_once $filename;
			}
		}

	}

	/**
	 * builds (relative) URL
	 *
	 * @param Actions(enum) $action [description]
	 * @param string  $param  (optional) extra query param value (right now only "song")
	 * @return  string
	 */
	public static function MakeUri($action, $param = ''){
		$directory = defined('Config::Subdirectory') ? Config::Subdirectory : '/';
		$actionName = Actions::ToName($action);
		$param = trim($param);

		if (!Config::UseModRewrite){
			$actionParams = strlen($param) > 0 ? '&song=' . $param : '';
			return $directory . 'music.php?action=' . $actionName . $actionParams;
		}

		if ($action == Actions::Song ) {
			$actionName = 'songbook';
		}
		return $directory . strtolower($actionName) . '/' . $param;
	}

	/**
	 * The rather quirky way to interface with jQuery.ajax with serialize,
	 * returns a PHP Object version of the posted JSON.
	 *
	 * @return Object
	 */
	public static function GetJsonObject(){
		$input = @file_get_contents('php://input');
		$response = json_decode($input);
		return $response;
	}

	/**
	 * Returns the name of the view file to include
	 *
	 * @param Actions(enum) $action
	 * @return string
	 */
	private function GetViewName( $action ) {
		switch($action){
			case Actions::Song:
				return Config::UseEditableSong ? 'song-editable.php' : 'song.php';
			case Actions::Edit:
				return 'song-editable.php';
			case Actions::Source:
				return 'song-source.php';
			case Actions::Reindex:
				return 'songs-rebuild-cache.php';
			case Actions::Login:
				return 'login.php';
			case Actions::Setlist:
				return 'setlist.php';
			case Actions::SaveSetlist:
				return 'save-setlist.php';
			case Actions::ListSetlists:
				return 'setlist-list.php';
			case Actions::DeleteSetlist:
				return 'delete-setlist.php';
			case Actions::CreatePDF:
				return 'create-pdf.php';
			case Actions::ListPDFs:
				return 'pdf-list.php';
			case Actions::DownloadPDF:
				return 'download-pdf.php';
			case Actions::StartSetlist:
				return 'start-setlist.php';
			case Actions::ImportSpreadsheet:
				return 'import-spreadsheet.php';
			default:
				return Config::UseDetailedLists ? 'song-list-detailed.php' : 'song-list.php';
		}
		return Config::UseDetailedLists ? 'song-list-detailed.php' : 'song-list.php';
	}

}
