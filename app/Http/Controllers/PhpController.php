<?php

namespace App\Http\Controllers;

use App\Models\Php;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Service\IniEdit;

class PhpController extends Controller
{
    protected array $editable = [
        'max_execution_time',
        'max_input_time',
        'memory_limit',
        'post_max_size',
        'upload_max_filesize',
    ];

    /**
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application
    {
        $phps = Php::orderBy('version', 'desc')->get();

        return view('Php.index', [
            'phps' => $phps,
        ]);
    }

    /**
     * @param Php $php
     * @return Factory|View|Application
     */
    public function edit(Php $php): Factory|View|Application
    {
        $ini = new IniEdit($php->path.'/php.ini');

        return view('Php.edit', [
            'php'      => $php,
            'ini'      => $ini,
            'editable' => $this->editable,
        ]);
    }

    /**
     * @param Php $php
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Php $php, Request $request): RedirectResponse
    {
        $request->validate([
            'cmd_php' => ['string', 'required'],
            'cmd_composer' => ['string', 'required'],
        ]);

        foreach ($this->editable as $edit) {
            $request->validate([$edit => ['string', 'required']]);
        }

        $php->update([
            'cmd_php'      => $request->input('cmd_php'),
            'cmd_composer' => $request->input('cmd_composer'),
        ]);

        $editRequest = array_intersect_key($request->all(), array_flip($this->editable));

        (new IniEdit($php->path.'/php.ini'))->update($editRequest);

        return redirect()->back()->with('success', __('PHP Version Updated'));
    }
}
