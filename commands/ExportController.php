<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ExportController extends Controller
{

    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex($message = 'use export/user')
    {
        echo $message . "\n";
    }

    public function actionSendUser($email = 'eugene.fabrikov@gmail.com')
    {
        echo 'Start export.' . PHP_EOL;
        echo 'Email: ' . $email . PHP_EOL;

        // Наше PDO подключение к БД
        $db        = Yii::$app->db;
        // Размер одной части обрабатываемых данных
        $part_size = 1000;
        $fields    = [
            'user.id'           => 'ID',
            'profile.name'      => 'Name',
            'profile.last_name' => 'Last Name',
            'user.social_id'    => 'Social ID',
            'created_at'        => 'Created at'
        ];
        // Файл, в который будем записывать результат (в корне сайта)
        $fname     = Yii::$app->basePath . '/export/' . md5(time()) . '.csv';
        $f         = @fopen($fname, 'w');

        // Записываем в начало файла заголовок для sitemap-файла
        $csvHeader = '"' . implode('";"', $fields) . '"';
        fwrite($f, $csvHeader . PHP_EOL);

        $query     = new \yii\db\Query();
        // Команда, которая будет делать порционную выборку новостей
        $query->select(implode(',', array_keys($fields)));
        $query->from('user, profile');
        $query->andWhere('user.id = profile.user_id');
        //$query->join('LEFT JOIN', 'profile', 'user.id = profile.user_id');
        // Определяем количество данных, которое нам нужно обработать
        $all_count = (int) $db->createCommand("SELECT COUNT(id) FROM user")->queryScalar();
        // Устанавливаем лимит, сколько новостей надо выбрать из таблицы
        $query->limit($part_size);
        // Перебираем все части данных
        for ($i = 0; $i < ceil($all_count / $part_size); $i++) {
            // Сюда будем складывать порции данных, для записи в файл, каждый
            // элемент массива - это одна строка
            $part   = array();
            // Вычисляем отступ от уже обработанных данных
            $offset = $i * $part_size;
            // Устанавливам отступ
            $query->offset($offset);
            // Находим очередную часть данных
            $rows   = $query->all();
            // Перебираем найденные данные
            foreach ($rows as $row) {
                $row['created_at'] = date('m-d-Y', $row['created_at']);
                // Открываем тег <url> - начало описания элемента в sitemap-файле
                $part[]            = '"' . implode('";"', $row) . '"';
            }
            // Убираем из памяти найденную часть данных
            unset($rows);
            // Добавляем в наш файл обработанную часть данных
            if (count($part)) {
                // Здесь мы объединяем все элементы массива $xml в строки
                fwrite($f, implode(PHP_EOL, $part) . PHP_EOL);
            }
            unset($part);
        }

        // Заканчиваем работу с файлом
        fclose($f);

        Yii::$app->mailer->compose('export', [
                'action' => 'user',
                'type'   => 'csv',
            ])
            ->setSubject(Yii::$app->name . ' | Export user')
            ->setTo($email)
            ->attach($fname)
            ->send();

        unlink($fname);
    }

    public function actionUser()
    {
        echo 'Start export.' . PHP_EOL;

        // Наше PDO подключение к БД
        $db        = Yii::$app->db;
        // Размер одной части обрабатываемых данных
        $part_size = 1000;
        $fields    = [
            'user.id'           => 'ID',
            'profile.name'      => 'Name',
            'profile.last_name' => 'Last Name',
            'user.social_id'    => 'Social ID',
            'created_at'        => 'Created at'
        ];
        // Файл, в который будем записывать результат (в корне сайта)
        $fname     = Yii::$app->basePath . '/export/user.csv';
        $f         = @fopen($fname, 'w');

        // Записываем в начало файла заголовок для sitemap-файла
        $csvHeader = '"' . implode('";"', $fields) . '"';
        fwrite($f, $csvHeader . PHP_EOL);

        $query     = new \yii\db\Query();
        // Команда, которая будет делать порционную выборку новостей
        $query->select(implode(',', array_keys($fields)));
        $query->from('user, profile');
        $query->andWhere('user.id = profile.user_id');
        //$query->join('LEFT JOIN', 'profile', 'user.id = profile.user_id');
        // Определяем количество данных, которое нам нужно обработать
        $all_count = (int) $db->createCommand("SELECT COUNT(id) FROM user")->queryScalar();
        // Устанавливаем лимит, сколько новостей надо выбрать из таблицы
        $query->limit($part_size);
        // Перебираем все части данных
        for ($i = 0; $i < ceil($all_count / $part_size); $i++) {
            // Сюда будем складывать порции данных, для записи в файл, каждый
            // элемент массива - это одна строка
            $part   = array();
            // Вычисляем отступ от уже обработанных данных
            $offset = $i * $part_size;
            // Устанавливам отступ
            $query->offset($offset);
            // Находим очередную часть данных
            $rows   = $query->all();
            // Перебираем найденные данные
            foreach ($rows as $row) {
                $row['created_at'] = date('m-d-Y', $row['created_at']);
                // Открываем тег <url> - начало описания элемента в sitemap-файле
                $part[]            = '"' . implode('";"', $row) . '"';
            }
            // Убираем из памяти найденную часть данных
            unset($rows);
            // Добавляем в наш файл обработанную часть данных
            if (count($part)) {
                // Здесь мы объединяем все элементы массива $xml в строки
                fwrite($f, implode(PHP_EOL, $part) . PHP_EOL);
            }
            
            unset($part);
        }

        // Заканчиваем работу с файлом
        fclose($f);

        echo 'Done.' . PHP_EOL;
    }
}