<?php
use App\Exception\ApplicationException;
use Illuminate\Support\Str;

function dd(...$params)
{
    echo '<pre>';
    var_dump($params);
    echo '</pre>';
    die;
}

function dump(...$params)
{
    echo '<pre>';
    var_dump($params);
    echo '</pre>';
}

function array_get(array $array, string $key, $default = null)
{
    $keys = explode('.', $key);

    for ($i = 0; $i < count($keys); $i++) {
        if (!empty($array[$key])) {
            $array = $array[$key];
        } else return $default;
    }

    return $array;
}

function file_upload($target_dir, $input_name)
{
    $imageFileType = strtolower(pathinfo($_FILES[$input_name]['name'],PATHINFO_EXTENSION));
    $target_name = Str::slug(pathinfo($_FILES[$input_name]['name'], PATHINFO_FILENAME));
    $target_file = $target_dir . $target_name . '.' . $imageFileType;

    // Check if image file is a actual image or fake image
    if (!isset($_POST['submit']) || !getimagesize($_FILES[$input_name]['tmp_name'])) {
        throw new ApplicationException('File is not an image');

    } elseif (file_exists($target_file)) { // Check if file already exists
        throw new ApplicationException('Sorry, file already exists.');

    } elseif ($_FILES[$input_name]['size'] > 2000000) { // Check file size
        throw new ApplicationException('Sorry, your file is too large.');

    } elseif ($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg'
        && $imageFileType != 'gif' ) { // Allow certain file formats
        throw new ApplicationException('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');

    } elseif (!move_uploaded_file($_FILES[$input_name]['tmp_name'], $target_file)) {
        throw new ApplicationException('Sorry, there was an error uploading your file.');

    } else {
        return $target_name . '.' . $imageFileType;
    }
}

function fake_mail($subscriber, $data)
{
    $message = date("D M j G:i:s T Y") . "\n";
    $message .= "Отправлено получателю: $subscriber->email \n\n";
    $message .= "Заголовок письма: На сайте добавлена новая запись: “" . $data->title . "”\n";
    $message .= "Содержимое письма:\n";
    $message .= "Новая статья: “" . $data->title . "”\n";
    $message .= $data->description . "\n";
    $message .= "<a href=\"http://" . $_SERVER['HTTP_HOST'] . "/posts/" . $data->id . "\">Читать</a>\n";
    $message .= "-------\n";
    $message .= "<a href=\"http://" . $_SERVER['HTTP_HOST'] . "/unsubscribe/" . $subscriber->nonce . "\">Отписаться от рассылки</a>\n\n\n";

    $fo = fopen($_SERVER['DOCUMENT_ROOT'] . '/log/mailing_log.txt',"a+");
    if ($fo) fwrite($fo, $message);
}

function string_lenght_control($string, $length = 200)
{

    if (strlen($string) > $length) {
        return substr($string, 0, $length-3) . '...';
    } else {
        return $string;
    }
}
