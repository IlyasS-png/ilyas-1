<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Livewire\Attributes\On;

class ProductIndex extends Component
{
    public $name, $description, $price, $productID;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable',
        'price' => 'required|numeric',
    ];

    public function render()
    {
        $data['products'] = Product::paginate(10);
        return view('livewire.product-index', $data);
    }

    public function save(){
        $this->validate();
        $input['name'] = $this->name;
        $input['description'] = $this->description;
        $input['price'] = $this->price;
        if($this->productID){
            $product = Product::find($this->productID);
            $product->update($input);
            session()->flash('message', 'Product Updated Successfullehhh');
            $this->dispatch('productSaved');   
        }else{
            Product::create($input);
            session()->flash('message', 'Product Created Successfullehhh');
            $this->dispatch('productSaved');
        }
        $this->reset();
    }

    public function edit($id){
        $product = Product::find($id);
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->productID = $product->id;

    }

    public function deleteConfirm($id){
        $this->dispatch('confirmDelete', id : $id, message : 'Are you sure you want to delete this product?');
    }
    #[On('delete')]
    public function delete($id){
        $product = Product::find($id);
        $product->delete();
        session()->flash('message', 'Product Deleted Successfully');
        $this->dispatch('productSaved', message : 'Product Deleted Successfully');
    }
}