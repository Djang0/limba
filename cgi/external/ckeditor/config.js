/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	config.filebrowserBrowseUrl = '/external/kcfinder/browse.php?type=files';
    config.filebrowserImageBrowseUrl = '/external/kcfinder/browse.php?type=files';
    config.filebrowserFlashBrowseUrl = '/external/kcfinder/browse.php?type=files';
    config.filebrowserUploadUrl = '/external/kcfinder/upload.php?type=files';
    config.filebrowserImageUploadUrl = '/external/kcfinder/upload.php?type=files';
    config.filebrowserFlashUploadUrl = '/external/kcfinder/upload.php?type=files';
	config.language = 'fr';
	config.toolbar = 'MyToolbar';
	 
    config.toolbar_MyToolbar =
    [
        ['Source','-','Preview','-','Templates'],
        ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
        ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
        '/',
        ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
	    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
	    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
	    ['BidiLtr', 'BidiRtl'],
	    ['Link','Unlink','Anchor'],
	    ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
	    '/',
	    ['Styles','Format','Font','FontSize'],
	    ['TextColor','BGColor'],
	    ['Maximize', 'ShowBlocks'],
	    ['Code']
	    ];
    config.extraPlugins = 'syntaxhighlight';
    config.toolbar_Full.push(['Code']);
	// config.uiColor = '#AADC6E';
};
