<?php

Class LangChanger
{
    /*
    |
    | Gets the URL of the current page and applies the desired language to it.
    | If `lang` is set to "en" then the URL for the route `trips` should look
    | like `http://domain.com/en/trips`. If the `lang` is set to "" then the URL
    | should look like `http://domain.com/trips`.
    |
    */
    static function change($lang = "")
    {
        if (array_key_exists($lang, Config::get('app.locales'))) {
            if (array_key_exists(Request::segment(1), Config::get('app.locales'))) {
                $cleanPath = substr(Request::path(), 2);
                $translated = str_replace(Request::path(), $lang . $cleanPath, Request::url());
            }
            elseif (Request::segment(1) == null) {
                $translated = Request::url() . '/' . $lang;
            }
            else {
                $path = Request::path();
                $translated = Config::get('app.url') . '/' . $lang . '/' . $path;
            }

            return $translated;
        }
        else {
            if (array_key_exists(Request::segment(1), Config::get('app.locales'))) {
                $cleanPath = substr(Request::path(), 3);
                $default = str_replace(Request::path(), $cleanPath, Request::url());
            }
            else {
                $default = Request::url();
            }

            return $default;
        }
    }

}
