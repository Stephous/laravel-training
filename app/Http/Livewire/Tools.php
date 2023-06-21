<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Tool;
use App\Helpers\Money;

class Tools extends Component
{
    public $name;
    public $price;
    public $description;
    public $search;

    public function render()
    {
        return view('livewire.tools', [
            'tools' => $this->tools,
        ]);
    }

    public function create()
    {
        Tool::create([
            'name' => $this->name,
            'price' => new Money('EUR', $this->price, 1.2),
            'description' => $this->description,
        ]);
        $this->getToolsProperty();
    }

    public function search()
    {
        $this->tools = Tool::where('name', 'like', '%' . $this->search . '%')->get();
    }

    public function getToolsProperty()
    {
        return Tool::all();
    }

}
