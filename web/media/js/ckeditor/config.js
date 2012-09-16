CKEDITOR.editorConfig = function( config )
{
	config.language = 'es';
	config.resize_enabled = false;
	config.height = 500;
	config.extraPlugins = 'stylesheetparser';
	config.contentsCss = '/media/css/ckeditor.css';
	config.format_tags = 'p;h1;h2;h3;h4';
	config.toolbar = 'tbProyect';
	config.toolbar_tbProyect =
	[
		{ name: 'basicstyles', items : [ 'Format','Bold','Italic','Underline','Strike','Subscript','Superscript','-','Link','Unlink' ] },
		{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','JustifyLeft','JustifyCenter','JustifyRight' ] },
		{ name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
		{ name: 'insert', items : [ 'Image','Table' ] },
	];
	config.toolbar = 'tbBasica';
	config.toolbar_tbBasica =
	[
		{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','Link','Unlink' ] },
		{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent' ] },
	];
	/*config.extraPlugins = 'autogrow';
	config.autoGrow_minHeight = 100;
	config.autoGrow_maxHeight = 500;*/
};