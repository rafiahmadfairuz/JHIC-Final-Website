<?php

namespace App\Livewire\Kwu\Penjual;

use App\Models\KategoriProduk;
use App\Models\Produk;
use App\Models\Toko;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ProdukComponent extends Component
{
    use WithPagination, WithFileUploads;
    protected $paginationTheme = 'tailwind';

    public $toko_id, $nama, $harga, $stok, $gambar, $kategori_id, $deskripsi;
    public $produk_id;
    public $search = '';
    public $isOpen = false;
    public $deleteId = null;

    protected $rules = [
        'nama' => 'required|string|max:255',
        'harga' => 'required|numeric',
        'stok' => 'required|numeric',
        'deskripsi' => 'required|string',
        'kategori_id' => 'required',
        'gambar' => 'nullable|image|max:2048',
    ];



    public function create()
    {
        $this->resetInput();
        $this->openModal();
    }

    public function edit($id)
    {
        $p = Produk::findOrFail($id);
        $this->produk_id = $id;
        $this->toko_id = $p->toko_id;
        $this->harga = $p->harga;
        $this->nama = $p->nama;
        $this->deskripsi = $p->deskripsi;
        $this->stok = $p->stok;
        $this->kategori_id = $p->kategori_id;
        $this->gambar = null;

        $this->openModal();
    }

    public function store()
    {
        $toko = auth()->user()->tokos()->first();

        $this->validate();

        $data = [
            'toko_id' => $toko->id,
            'nama' => $this->nama,
            'deskripsi' => $this->deskripsi,
            'harga' => $this->harga,
            'stok' => $this->stok,
            'kategori_id' => $this->kategori_id,
            'gambar' => $this->gambar,
        ];

        if ($this->gambar) {
            $data['gambar'] = $this->gambar->store('produks', 'public');
        }

        Produk::updateOrCreate(['id' => $this->produk_id], $data);

        session()->flash('message',
            $this->produk_id ? 'Produk berhasil diperbarui.' : 'Produk berhasil ditambahkan.'
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
        Produk::findOrFail($this->deleteId)->delete();
        session()->flash('message', 'Produk berhasil dihapus.');
        $this->deleteId = null;
    }

    private function resetInput()
    {
        $this->toko_id = '';
        $this->nama = '';
        $this->deskripsi = '';
        $this->harga = '';
        $this->stok = '';
        $this->kategori_id = '';
        $this->gambar = null;
        $this->produk_id = null;
    }

    private function openModal() { $this->isOpen = true; }
    private function closeModal() { $this->isOpen = false; }

    public function render()
    {
        $produks = Produk::with('toko', 'kategori')
        ->when($this->search, function ($q) {
            $q->where('nama', 'like', '%'.$this->search.'%')
              ->orWhere('deskripsi', 'like', '%'.$this->search.'%')
              ->orWhereHas('kategori', function ($query) {
                  $query->where('nama', 'like', '%'.$this->search.'%');
              });
        })
        ->latest()
        ->paginate(10);

    $kategoris = KategoriProduk::all();

    return view('livewire.kwu.penjual.produk-component', compact(['produks', 'kategoris']));
    }
}
