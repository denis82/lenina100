CKEDITOR.plugins.add('filemanager',
{
	requires: ['iframedialog'],
    init: function(editor)
    {
        var pluginName = 'filemanager';
        CKEDITOR.dialog.addIframe('filemanager', 'File Manager', "/admin/filemanager/index");
        editor.addCommand(pluginName, new CKEDITOR.dialogCommand(pluginName));
        var cmd = editor.addCommand('filemanager', {exec: filemanager_onclick});
        editor.ui.addButton('filemanager',
            {
                label: 'filemanager',
                command: "filemanager",
                icon: this.path + 'images/icon.png'
            });
    },
    buttons: null
    
});
var currentInstanceName;
function filemanager_onclick(e) {
	var manager = window.open("/admin/filemanager/index/CKEditor/"+e.name, "File_manager","left=50,top=50,scrollbars=1");
	manager.focus();
}
