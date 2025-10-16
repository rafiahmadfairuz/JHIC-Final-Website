<?php

namespace App\Livewire\Kwu\Dashboard;

use App\Models\KategoriProduk;
use Livewire\Component;
use Livewire\WithPagination;

class KategoriprodukComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'tailwind';

    public $nama;
    public $kategori_id;
    public $isOpen = false;
    public $deleteId = null;

    protected $rules = [
        'nama' => 'required|string|max:255',
    ];


    public function create()
    {
        $this->resetInput();
        $this->openModal();
    }

    public function edit($id)
    {
        $kategori = KategoriProduk::findOrFail($id);
        $this->kategori_id = $id;
        $this->nama = $kategori->nama;

        $this->openModal();
    }

    public function store()
    {
        $this->validate();

        KategoriProduk::updateOrCreate(
            ['id' => $this->kategori_id],
            [
                'nama' => $this->nama,
            ]
        );

        session()->flash(
            'message',
            $this->kategori_id ? 'Kategori berhasil diperbarui.' : 'Kategori berhasil ditambahkan.'
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
        KategoriProduk::findOrFail($this->deleteId)->delete();
        session()->flash('message', 'Kategori berhasil dihapus.');
        $this->deleteId = null;
    }

    private function resetInput()
    {
        $this->nama = '';
        $this->kategori_id = null;
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
        $kategoris = KategoriProduk::latest()->paginate(10);
        return view('livewire.kwu.dashboard.kategoriproduk-component', compact('kategoris'));
    }
}
