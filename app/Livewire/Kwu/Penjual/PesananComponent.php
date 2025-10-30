<?php

namespace App\Livewire\Kwu\Penjual;

use App\Models\Order;
use Livewire\Component;
use App\Models\OrderItem;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class PesananComponent extends Component
{
    use WithPagination, WithFileUploads;
    protected $paginationTheme = 'tailwind';

    public $status;
    public $produk_id;
    public $isOpen = false;
    public $deleteId = null;

    protected $rules = [
        'status' => 'required',
    ];

    public function edit($id)
    {
        $p = Order::findOrFail($id);
        $this->produk_id = $id;
        $this->status = $p->status;

        $this->openModal();
    }

    public function update()
    {
        $toko = auth()->user()->tokos()->first();

        $this->validate();

        $order = Order::findOrFail($this->produk_id);

        $order->update([
            'status' => $this->status,
        ]);

        session()->flash(
            'message',
            $this->produk_id ? 'Pesanan berhasil diperbarui.' : 'Pesanan berhasil diperbarui.'
        );

        $this->closeModal();
        $this->resetInput();
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
    }

    public function delete()
    {
        Order::findOrFail($this->deleteId)->delete();
        session()->flash('message', 'Pesanan berhasil dihapus.');
        $this->deleteId = null;
    }

    private function resetInput()
    {
        $this->status = '';
    }

    private function openModal()
    {
        $this->isOpen = true;
    }
    private function closeModal()
    {
        $this->isOpen = false;
    }


    public function render()
    {
        $user = Auth::user()->id;
        
        $orders = OrderItem::with(['order', 'produk'])
            ->whereHas('produk.toko.users', function ($q) use ($user) {
                $q->where('user_id', $user);
            })->latest()->paginate(10);

        return view('livewire.kwu.penjual.pesanan-component', [
            'orders' => $orders
        ]);
    }

}
