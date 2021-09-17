<?php

namespace App\Http\Controllers;


use App\Models\Host;
use App\Models\Php;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AppController extends HostController
{
    /**
     * @return Factory|View|Application
     */
    public function create(): Factory|View|Application
    {
        $installers = config('installers');
        $versions = Php::orderBy('version', 'desc')->get();

        return view('App.create', [
            'versions'   => $versions,
            'title'      => __('Create App'),
            'installers' => array_keys($installers),
            'formAction' => route('apps.store'),
        ]);
    }

    /**
     * @param Host $host
     * @param Request $request
     * @return RedirectResponse
     */
    protected function afterStore(Host $host, Request $request): RedirectResponse
    {
        $createDb = (bool) $request->input('create-database');

        $app = config('installers.'.$request->input('installer'));

        $app['installer']::dispatch($host, $app['parameter'], $createDb, $request->input('db-name'));

        return redirect()->route('hosts.index')->with('success', __('Host and App created'));
    }
}
