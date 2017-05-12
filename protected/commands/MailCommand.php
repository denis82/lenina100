<?php
/**
 * Файл примеров установки заданий.
 *
 * @author Evgeny Blinov <e.a.blinov@gmail.com>
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @link http://code.google.com/p/w3lib/
 * @package W3CronCommand
 * @version $Id: ExampleCommand.php 19 2012-01-11 12:59:54Z E.A.Blinov@gmail.com $
 */

/**
 * Класс команды-примера устновки заданий.
 *
 * @author Evgeny Blinov <e.a.blinov@gmail.com>
 * @package W3CronCommand
 * @subpackage example
 * @version $Id: ExampleCommand.php 19 2012-01-11 12:59:54Z E.A.Blinov@gmail.com $
 */
class MailCommand extends CConsoleCommand{

    /**
     * Рассылка писем из дирректории application.runtime.comment_notifies
     * 
     * Запуск каждую минуту.
     * @cron * * * * *
     */
    public function actionExapmle1()
    {
        $dir = Yii::getPathOfAlias('application.runtime.comment_notifies');
        if (!file_exists($dir) || !is_dir($dir)) {
            return;
        } 

        chdir($dir);
        $files = glob('*.txt');
        if (!is_array($files)) {
            return;
        }

        $mm = Yii::app()->mailManager; // MailManager
        foreach ($files as $file) {
            $data = unserialize(file_get_contents($file)); 
            unlink($file);
            if (isset($data['subscribers']) && $data['message']) {
                $mm->send('Новый комментарий', $data['message'], $data['subscribers'], array('sendApart' => true));
            }
        }
    }
}
