<?php 
class Install
{
    public static $link = false;
    public static $result = array(
        'success' => false,
        'errors' => array(),
        'message' => ''
    );
    
    public static $fields = array(
        'host' => array(
            'label' => 'Сервер', 
            'value' => 'localhost',
            'required' => true,
        ),
        'dbname' => array(
            'label' => 'Имя базы данных', 
            'value' => '',
            'required' => true,
        ),
        'username' => array(
            'label' => 'Логин', 
            'value' => '',
            'required' => true,
         ),
        'password' => array(
            'label' => 'Пароль', 
            'value' => '',
            'required' => false,
        ),
        'tablePrefix' => array(
            'label' => 'Перфикс таблиц (необязательно)', 
            'value' => '',
            'required' => false,
         )
    );
    
    public static $dbContent = array(
        'connectionString' => '',
        'emulatePrepare' => true,
        'username' => '',
        'password' => '',
        'charset' => 'utf8',
        'tablePrefix' => '',
    );
    
    public static function getDbFile()
    {
        $s = DIRECTORY_SEPARATOR;
        return str_replace('install', '', dirname(__FILE__)). 'protected'. $s. 'config'. $s. '_db_production.php';
    }
    
    public static function processPost($POST)
    {
        if(!isset($POST['Install']))
            return self::$result;
        
        $post = $POST['Install'];

        foreach(self::$fields as $key=>$params){
            if(!isset($post[$key]) || !$post[$key]){
                if($params['required']){
                    self::$result['errors'][$key] = $params['label'];
                }
            }else{
                self::$fields[$key]['value'] = $post[$key];
            }
        }
        
        if(count(self::$result['errors']) > 0)
            return self::$result;
        
        if(!self::updateConnectionData())
            return self::$result;

        $file = isset($_FILES["Install"]) ? $_FILES["Install"]['tmp_name']['file'] : false;
        $delete = (isset($post['delete']) && $post['delete']=='on') ? 1 : false; 
        if($file || $delete)
            self::importMysql($file, $delete);
        
        mysql_close();
        return self::$result;
    }
    
    public static function updateConnectionData()
    {
        array_walk(self::$fields, function(&$v){$v=$v['value'];});
        self::$dbContent = array_merge(self::$dbContent, self::$fields);
        extract(self::$fields);
        self::$dbContent['connectionString'] = "mysql:host=$host;dbname=$dbname";

        self::$link = mysql_connect($host, $username, $password); 
        if(!self::$link){
            self::$result['message'] = 'Не удалось установить соединение.';
            return false;
        }else if(!mysql_select_db($dbname, self::$link)){
            self::$result['message'] = "База данных не найдена. \n";
            if (mysql_query("CREATE DATABASE $dbname", self::$link)){
                self::$result['message'] .= "База данных создана. \n";
                if(!mysql_select_db($dbname, self::$link)){
                    self::$result['message'] .= "Не удалось установить соединение с базой данных. \n";
                    return false;
                }
            }else{
                self::$result['message'] .= "Не удалось создать базу данных. \n";
                return false;
            }    
        }
        self::$result['success'] = "Соединение с базой данных установлено. \n";
        file_put_contents(self::getDbFile(), '');
        file_put_contents(self::getDbFile(), "<?php \n return ". var_export(self::$dbContent, true). ';');
        return true;
    }
     
    public static function importMysql($file, $delete)
    {
        extract(self::$fields);

        if($delete){
            $query = reset(mysql_fetch_row(
                mysql_query("SELECT CONCAT( 'DROP TABLE ', GROUP_CONCAT(table_name) , ';' ) 
                    AS statement FROM information_schema.tables 
                    WHERE table_schema = '$dbname' AND table_name LIKE '$tablePrefix%'")
            ));
            if (mysql_query($query, self::$link))
                self::$result['success'] .= "База данных успешно удалена";
            else
                self::$result['message'] .= "Не удалось удалить базу данных.\n";
        }
        if($file){
            shell_exec("mysql -u{$username} -p{$password} -h {$host} -D {$dbname} < {$file}");
            self::$result['success'] = "База данных успешно обновлена"; 
        }
    }
}
