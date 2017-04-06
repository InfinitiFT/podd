/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	var baseurl = "http://172.16.0.9/PROJECTS/MobileiOSAndroidChatDatingApplication/trunk/"
	config.filebrowserBrowseUrl = baseurl+'assets/plugins/ckeditor/kcfinder/browse.php?opener=ckeditor&type=files';
   	config.filebrowserImageBrowseUrl = baseurl+'assets/plugins/ckeditor/kcfinder/browse.php?opener=ckeditor&type=images';
   	config.filebrowserFlashBrowseUrl = baseurl+'assets/plugins/ckeditor/kcfinder/browse.php?opener=ckeditor&type=flash';
   	config.filebrowserUploadUrl = baseurl+'assets/plugins/ckeditor/kcfinder/upload.php?opener=ckeditor&type=files';
   	config.filebrowserImageUploadUrl = baseurl+'assets/plugins/ckeditor/kcfinder/upload.php?opener=ckeditor&type=images';
   	config.filebrowserFlashUploadUrl = baseurl+'assets/plugins/ckeditor/kcfinder/upload.php?opener=ckeditor&type=flash';
};
