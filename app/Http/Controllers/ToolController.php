<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Tool;

class ToolController extends Controller
{
    public function index() : View {

        /*$tools = [
            (object) [
                "name" => "Marteau",
                "description" => "pour frapper et enfoncer des clous dans du bois ou d'autres matériaux.",
                "price" => "23.99",
            ],
            (object) [
                "name" => "Tournevis",
                "description" => "pour serrer ou desserrer les vis.",
                "price" => "15.99",
            ],
            (object) [
                "name" => "Scie",
                "description" => "pour couper le bois, le métal ou d'autres matériaux.",
                "price" => "56.33",
            ],
        ];*/
        $tools = Tool::all();
        return View('tools.index',compact('tools'));
    }
    /*public function show(int $id) : View {
        $tool = Tool::findOrFail($id);
        return View('tools.show',compact('tool'));
    }*/
    public function show(Tool $tool) : View {
        return View('tools.show',compact('tool'));
    }
}
