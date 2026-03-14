<?php

namespace App\Livewire\Admin\Orders;

use App\Models\Order;
use App\Services\OrderService;
use Livewire\Component;

class OrderDetail extends Component
{
    public Order $order;
    public string $newStatus = '';
    public string $adminNotes = '';

    public function mount(int $id): void
    {
        $this->order = Order::with('items.product')->findOrFail($id);
        $this->newStatus  = $this->order->status;
        $this->adminNotes = $this->order->admin_notes ?? '';
    }

    public function updateStatus(OrderService $orderService): void
    {
        if ($this->newStatus !== $this->order->status) {
            $orderService->updateStatus($this->order, $this->newStatus);
            $this->order->refresh();
        }

        if ($this->adminNotes !== $this->order->admin_notes) {
            $this->order->update(['admin_notes' => $this->adminNotes]);
        }

        $this->dispatch('show-toast', message: 'Order updated successfully.', type: 'success');
    }

    public function render()
    {
        return view('livewire.admin.orders.order-detail')
            ->layout('layouts.admin', ['title' => 'Order ' . $this->order->order_number]);
    }
}
