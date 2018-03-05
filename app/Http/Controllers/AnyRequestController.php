<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App;
use App\Page;
use App\Role;
use App\Settings;

class AnyRequestController extends Controller
{

    public function index(Request $request)
    {
        return $this->show($request);
    }

    public function show(Request $request)
    {
        $sLanguage = $request->input('language');
        $sURI = $request->input('id');

        $aURI = explode('/', $sURI);

        App::setLocale($sLanguage ?: 'en');

        /*
        if (isset($aURI[0]) && $aURI[0] == config('app.adminPath')) {
            echo "admin";
            if (Auth::check()) {
                return \App::call('Admin\IndexController@index');
                //route('ESProfile', ["language" => "en"]);
                //return redirect()->action('Admin\IndexController@index', [ "language" => $in_sLanguage ]);
            } else {
                return redirect()->route("login", $in_sLanguage); //->action('LoginController@index', [ "language" => "en" ]);
            }
        }
        */

        if (!$sLanguage or !isset($aURI[1])) {
            if ($objSettings = Settings::where('name', '=', 'start page')->firstOrFail()) {
                if ($objStartPage = Page::where('id', '=', $objSettings->value)->firstOrFail()) {
                    if (Page::isTemplate($objStartPage->layout_template)) {
                        return view("layouts/" . $objStartPage->layout_template, [
                            "title" => '',
                            "content" => view($objStartPage->template),
                        ]);
                    } else {
                        abort(404);
                    }
                }
            }
        }

        if ($objPage = Page::where('uri', '=', end($aURI))->firstOrFail()) {
            if (Page::isTemplate($objPage->layout_template)) {
                view("layouts/" . $objPage->layout_template, [
                    "title" => '',
                    "content" => view($objPage->template),
                ]);
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }


        //$this->layout = "layouts/base/layout";
    }
}
