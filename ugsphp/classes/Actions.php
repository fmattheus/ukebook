<?php
/**
 * Enum for possible Actions (url to ViewModel mappings)
 * @class Actions
 * @namespace ugsPhp
 */
final class Actions {
	const Song = 0;
	const Songbook = 1;
	const Source = 2;
	const Reindex = 3;
	const Login = 4;
	const Logout = 5;
	const Edit = 6;
	// AJAX Actions
	const AjaxNewSong = 7;
	const AjaxUpdateSong = 8;
	// Setlist Actions
	const Setlist = 9;
	const SaveSetlist = 10;
	const ListSetlists = 11;
	const DeleteSetlist = 12;
	const CreatePDF = 13;
	const ListPDFs = 14;
	const DownloadPDF = 15;
	const StartSetlist = 16;
	const ImportSpreadsheet = 17;

	/**
	 * convert passed in string value to corresponding Actions enum
	 * @param [string] $value
	 * @return  Actions
	 */
	public static function ToEnum($value){
		switch (strtolower($value)) {
			case 'song': return self::Song;
		 	case 'reindex':  return self::Reindex;
		 	case 'source': return self::Source;
		 	case 'edit': return self::Edit;
		 	case 'login': return self::Login;
		 	case 'logout': return self::Logout;
		 	case 'ajaxnewsong': return self::AjaxNewSong;
		 	case 'ajaxupdatesong': return self::AjaxUpdateSong;
		 	case 'setlist': return self::Setlist;
		 	case 'savesetlist': return self::SaveSetlist;
		 	case 'listsetlists': return self::ListSetlists;
		 	case 'deletesetlist': return self::DeleteSetlist;
		 	case 'createpdf': return self::CreatePDF;
		 	case 'listpdfs': return self::ListPDFs;
		 	case 'downloadpdf': return self::DownloadPDF;
		 	case 'startsetlist': return self::StartSetlist;
		 	case 'importspreadsheet': return self::ImportSpreadsheet;
		 }
		 return self::Songbook;
	}

	/**
	 * Converts Actions enum to a string; you should use this for URI's
	 * @param Actions(int-enum) $value
	 * @return string
	 */
	public static function ToName($value){
		switch($value){
			case self::Song: return 'Song';
			case self::Source: return 'Source';
		 	case self::Edit: return 'edit';
			case self::Reindex: return 'Reindex';
			case self::Login: return 'Login';
			case self::Logout: return 'Logout';
			case self::AjaxNewSong: return 'AjaxNewSong';
			case self::AjaxUpdateSong: return 'AjaxUpdateSong';
			case self::Setlist: return 'Setlist';
			case self::SaveSetlist: return 'SaveSetlist';
			case self::ListSetlists: return 'ListSetlists';
			case self::DeleteSetlist: return 'DeleteSetlist';
			case self::CreatePDF: return 'CreatePDF';
			case self::ListPDFs: return 'ListPDFs';
			case self::DownloadPDF: return 'DownloadPDF';
			case self::StartSetlist: return 'StartSetlist';
			case self::ImportSpreadsheet: return 'ImportSpreadsheet';
		}
		return 'Songbook';
	}
}
