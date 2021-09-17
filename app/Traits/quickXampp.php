<?php


namespace App\Traits;

use App\Service\Xampp;


use Illuminate\Http\RedirectResponse;

trait quickXampp
{
    public function updateHostFile(): RedirectResponse
    {
        (new Xampp)->updateHostFile();

        return redirect()->back()->with('success', __('Host File updated'));
    }

    public function updateVHostConf(): RedirectResponse
    {
        (new Xampp)->updateVhostsConf();

        return redirect()->back()->with('success', __('VHosts updated'));
    }
}
