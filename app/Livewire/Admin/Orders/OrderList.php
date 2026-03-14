<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use Livewire\Attributes\Computed;

class OrderList extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $status = '';

    #[Url]
    public string $sort = 'newest';

    public function updatedSearch(): void { $this->resetPage(); }
    public function updatedStatus(): void { $this->resetPage(); }

    #[Computed]
    public function orders()
    {
        $query = Order::with('items');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('order_number', 'like', "%{$this->search}%")
                  ->orWhere('billing_name', 'like', "%{$this->search}%")
                  ->orWhere('billing_email', 'like', "%{$this->search}%");
            });
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        match ($this->sort) {
            'total_desc' => $query->orderBy('total', 'desc'),
            'total_asc'  => $query->orderBy('total', 'asc'),
            'oldest'     => $query->oldest(),
            default      => $query->latest(),
        };

        return $query->paginate(15);
    }

    public function render()
    {
        return view('livewire.admin.orders.order-list')
            ->layout('layouts.admin', ['title' => 'Orders']);
    }
}
