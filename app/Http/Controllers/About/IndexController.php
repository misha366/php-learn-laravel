<?php

namespace App\Http\Controllers\About;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

// Пример однометодного контроллера - создаётся в папке, а каждый класс
// отвечает за каждый отдельный роут
class IndexController extends Controller {
    public function __invoke() : View {
        return view("about/index", [
            "title" => "About",
        ]);
    }
}
