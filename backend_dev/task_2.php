<?
namespace FeedComponent;

class FeedParsingComponent
{
    public function __construct(string $url_or_file_path, array $settings_list)
    {
        // получаем объект с разобранным XML при помощи simplexml_load_file
        // дескриптор подключения к бд или к облаку с помощью $settings_list
        // дескриптор почты с помощью SendMailSmtpClass
    }

    public function GettingXmlElems()
    {
        // разбираем список элементов <flowers>:
        /*
        <flower>
        последовательно забираем все теги: <title>, <description>, таксоны и ссылки на фото
        </flower>
        return список с данными для каждого <flower>;
        */
    }

    public function LoadPhotos(array $data_list) // список с данными для каждого <flower>
    {
        /*
         $data_list = array(
            flower n => array(<title>, <description>, array(таксоны), array(ссылки на фото))
            )
        */

        // находим у каждого цветка в $data_list все ссылки на его фото, скачаиваем, переводим в бинарное представление и формируем новый
        // список готовый для выгрузки:
        /*
         $new_data_list = array(
            flower n => array(<title>, <description>, array(таксоны), array(фото в бинарном представлении))
            )
        */
        // с помощью созданного в конструкторе дескриптора заносим его в хранилище 
        
        // вызываем метод отправки сообщения $this->SendEmail();

        /*
        для повышения производительности можно скачивание для каждого цветка поместить в свой поток исполнения с помощью модуля pthreads
        более простого решения для добавления многопоточности компонента не знаю
        */
        
    }
    
    private function SendEmail()
    {
        // по завершении сохранения данных в облаке или бд отправляем сообщение на почту об окончании с помощью SendMailSmtpClass объекта
    }
    
    function __destruct()
    {
       
    }
}