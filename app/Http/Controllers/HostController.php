<?php

namespace App\Http\Controllers;

use App\Models\Host;
use App\Models\Php;
use App\Rules\LocalDomain;
use App\Rules\PathExist;
use App\Traits\quickXampp;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HostController extends Controller
{
    use quickXampp;

    /**
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application
    {
        $hosts = Host::orderBy('name')->get();

        return view('Host.index', [
            'hosts' => $hosts,
        ]);
    }

    public function create(): Factory|View|Application
    {
        $versions = Php::orderBy('version', 'desc')->get();

        return view('Host.create', [
            'title'      => __('Create Host'),
            'versions'   => $versions,
            'formAction' => route('hosts.store'),
        ]);
    }

    /**
     * @param Host $host
     * @param Request $request
     * @return RedirectResponse
     */
    protected function afterStore(Host $host, Request $request): RedirectResponse
    {
        return redirect()->route('hosts.index')->with('success', __('Host created'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $subdomains = $request->input('subdomains');
        $subdomains = array_map('cleanUpHost', $subdomains);
        $subdomains = array_filter($subdomains);

        $php = Php::find($request->input('version'));

        if (!is_dir($request->input('path'))) {
            mkdir($request->input('path'), 0777, true);
        }

        $request->validate([
            'domain' => ['string', 'required', new LocalDomain],
            'path'   => ['string', 'required', new PathExist],
        ]);

        $host = $php->hosts()->updateOrCreate(
            ['domain' => $request->input('domain')],
            [
                'name'       => $request->input('name'),
                'subdomains' => $subdomains,
                'path'       => winSep($request->input('path')),
            ]
        );

        return $this->afterStore($host, $request);
    }

    /**
     * @param Host $host
     * @return RedirectResponse
     */
    public function destroy(Host $host): RedirectResponse
    {
        $host->delete();

        return redirect()->route('hosts.index');
    }

    /**
     * @param Host $host
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Host $host, Request $request): RedirectResponse
    {
        $subdomains = $request->input('subdomains');
        $subdomains = array_map('cleanUpHost', $subdomains);
        $subdomains = array_filter($subdomains);

        $php = Php::findOrFail($request->input('version'));

        $request->validate([
            'domain' => ['string', 'required', new LocalDomain],
            'path'   => ['string', 'required', new PathExist],
        ]);

        $host->update([
            'php_id'     => $php->id,
            'name'       => $request->input('name'),
            'domain'     => $request->input('domain'),
            'subdomains' => $subdomains,
            'path'       => winSep($request->input('path')),
        ]);

        return redirect()->route('hosts.index')->with('success', __('Host updated'));
    }

    /**
     * @param Host $host
     * @return RedirectResponse
     */
    public function show(Host $host): RedirectResponse
    {
        return redirect()->route('hosts.index');
    }

    /**
     * @param Host $host
     * @return Factory|View|Application
     */
    public function edit(Host $host): Factory|View|Application
    {
        $versions = Php::orderBy('version', 'desc')->get();

        return view('Host.edit', [
            'host'     => $host,
            'versions' => $versions,
        ]);
    }
}
