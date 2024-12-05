<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class Helper
{
    public static function removeOuterPTag(?string $html): ?string
    {
        if(empty($html)){
            return $html;
        }

        // Регулярное выражение для удаления единственного внешнего тега <p>
        $pattern = '/^<p>(?!.*<p>)(.*)<\/p>$/s';

        // Проверяем и удаляем тег
        if (preg_match($pattern, $html)) {
            return preg_replace($pattern, '$1', $html);
        }

        return $html;
    }


    public static function makeImageWhite(string $filepath): void
    {
        $disallowedExtensions = ['svg', 'jpeg', 'jpg'];
        $fileExtension = strtolower(pathinfo($filepath, PATHINFO_EXTENSION));
        if (in_array($fileExtension, $disallowedExtensions)) {
            return;
        }

        $manager = new ImageManager(new Driver());
        $image = $manager->read($filepath);

        $image->brightness(-100);  // Уменьшаем яркость до 0
        $image->invert();          // Инвертируем цвета (чтобы сделать логотип белым)

        $image->save($filepath);
    }
}
