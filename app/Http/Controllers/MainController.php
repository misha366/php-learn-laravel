<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class MainController extends Controller {
    const VIEW_NAME_INDEX = "index";

    const VIEW_DATA_KEY_TITLE = "title";
    const VIEW_DATA_KEY_TITLE_VALUE = "Homepage";

    public function index() : View {
        return view(self::VIEW_NAME_INDEX, [
            self::VIEW_DATA_KEY_TITLE => self::VIEW_DATA_KEY_TITLE_VALUE
        ]);
    }
}
