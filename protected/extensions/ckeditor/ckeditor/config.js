/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
        config.toolbar = 'MyToolbarSet'

        config.defaultLanguage = 'ru'
        config.language = 'ru'

	config.toolbar_MyToolbarSet =
	[
	    ['Maximize','Save','Cut','Copy','Paste','Undo','Redo','PasteFromWord'],
	    '/',
	    ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
	    ['NumberedList','BulletedList','Outdent','Indent','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
	    ['Link','Unlink'],
	    ['filemanager','Flash','Image','Table','HorizontalRule','SpecialChar'],
	    '/',
	    ['Styles','Format'],
	    ['ShowBlocks', 'Source']
	]
};
