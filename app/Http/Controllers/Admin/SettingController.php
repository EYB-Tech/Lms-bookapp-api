<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:settings_update']);
    }

    public function update(Request $request)
    {
        Artisan::call('cache:clear');
        foreach ($request->all() as $field => $value) {
            $lang = null;
            if ($request->hasFile($field)) {
                if (gettype($value) == 'array') {
                    $images = json_decode(get_setting($field), true) ?? [];
                    foreach ($value as $key => $image) {
                        // If a new image is uploaded, replace the old one, otherwise keep the old image
                        if ($request->file($field)[$key]) {
                            $images[$key] = mediaUploadImage('site', $image, $images[$key] ?? null);
                        }
                    }
                    update_setting($field, json_encode($images));
                } else {
                    $image = mediaUploadImage('site', $request->file($field), get_setting($field), '.png');
                    update_setting($field, $image);
                }
            } else {
                if ($request->input('lang')) {
                    $lang = isset($request->input('lang')[$field]) ? $request->input('lang')[$field] : null;
                }
                if ($field != 'lang' && $field != '_token') {
                    if (gettype($value) == 'array') {
                        update_setting($field, json_encode($value), $lang);
                    } else {
                        update_setting($field, $value, $lang);
                    }
                }
            }
        }
        if ($request->site_title) {
            setEnvValue([
                'APP_NAME' => $request->site_title
            ]);
        }
        Artisan::call('cache:clear');
        session()->flash('success', __('Updated successfully'));
        return back();
    }

    /**
     * Website Setup
     */
    public function homepage_settings(Request $request)
    {
        $lang = request()->query('lang', default_lang());
        return view('admin.pages.website-setup.homepage', compact('lang'));
    }

    public function basic_settings(Request $request)
    {
        return view('admin.pages.website-setup.basic');
    }

    public function auth_layout_settings(Request $request)
    {
        $lang = request()->query('lang', default_lang());
        return view('admin.pages.website-setup.auth-layout', compact('lang'));
    }

}
