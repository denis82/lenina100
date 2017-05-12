Yii Blog Demo & simpleWorkflow Extension
----------------------------------------

This webApp is the modified Yii Blog Demo web application, provided with
any Yii releases. It is now able to use the simpleWorkflow Extension.
Please note that this version of the yiiBlog demo can't be used with the original
database schema as it requires a small modification in the tbl_post table (see below).

The workflow associated with Post model is located in protected/models/workflow/swPost.php.

Following files have been modified :

 ./protected/index.php
 	- activate log and trace level (3) 	
 	- set $yii so it refers to the installed Yii Framework version : ** UPDATE TO FIT YOUR OWN ENVIRONMENT SETTINGS **
 	
 	
 ./protected/config/main.php
 	- import application.extensions.simpleWorkflow.*
 	- declare component swSource 
 	
./protected/data/schema.mysql.sql
	- table tbl_post creattion : column status has been changed from
	'int' to 'varchar'
	 	
./protected/data/schema.sqlite.sql
	- table tbl_post creattion : column status has been changed from
	'int' to 'varchar'
	
./protected/models/Post.php
	- modify validation rule for attribute 'status' 
	from
		 array('status', 'in', 'range'=>array(1,2,3)),
	to
		array('status', 'SWValidator'),
	- add method 'behaviors'
	
./protected/views/post/_form.php
	- modify dropdown list creation so to only display accessible statuses
	 	
./protected/views/post/_form.php
	- modify column 'status' configuration for the CGridView Widget



	