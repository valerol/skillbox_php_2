<?php
namespace App\Controllers;

use App\View\View;
use App\Model\Setting;

/**
 * Class SettingsController
 * @package App\Controllers
 */
class SettingsController
{
    /**
     * @return View
     */
    public function settingList() : View
    {
        return new View('admin.view.settings', ['title' => 'Настройки', 'settings' => Setting::getAll()]);
    }

    /**
     * @return View
     */
    public function settingUpdateAction() : View
    {
        $settings = Setting::getAll();

        foreach ($settings as $setting) {

            if (isset($_POST[$setting->name])) {
                Setting::updateSetting($setting->id, $_POST[$setting->name]);
            }
        }

        $settings = $settings->fresh();

        return new View('admin.view.settings', ['title' => 'Настройки', 'settings' => $settings]);
    }
}
