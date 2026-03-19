<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdatePlatformSettingRequest;
use App\Services\SettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function edit(SettingService $settings): View
    {
        return view('admin.settings.edit', [
            'settings' => $settings->allGrouped(),
            'flatSettings' => [
                'store_name' => $settings->get('store_name', 'UniShopnex'),
                'support_email' => $settings->get('support_email', 'support@unishopnex.test'),
                'currency' => $settings->get('currency', 'USD'),
                'homepage_hero' => $settings->get('homepage_hero', ''),
            ],
        ]);
    }

    public function update(UpdatePlatformSettingRequest $request, SettingService $settings): RedirectResponse
    {
        $settings->setMany('platform', $request->validated());

        return Redirect::route('admin.settings.edit')->with('status', 'Settings updated successfully.');
    }
}
