<?php

namespace App\Livewire\Kwu\Landing;

use App\Models\Produk;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\KategoriProduk;

class BerandaComponent extends Component
{
    use WithPagination;

    public $min_price;
    public $max_price;
    public $kategoris;
    public $search = '';
    public $sort = 'default';
    public $selectedKategori = null;
    public $temp_selectedKategori;
    public $showFilter = false;

    public $temp_min_price;
    public $temp_max_price;
    public $temp_sort;


    protected $queryString = [
        'min_price',
        'max_price',
        'sort',
        'selectedKategori' => ['except' => ''],
        'search' => ['except' => ''],
    ];

    public function setKategori($kategoriId)
    {
        $this->selectedKategori = $kategoriId;
        $this->resetPage();
    }

    public function updatingSelectedKategori()
    {
        $this->resetPage();
    }


    public function mount()
    {
        $this->kategoris = KategoriProduk::all();

        $this->temp_min_price = $this->min_price;
        $this->temp_max_price = $this->max_price;
        $this->temp_sort = $this->sort;
        $this->temp_selectedKategori = $this->selectedKategori;
    }

    public function applyFilter()
    {
        $this->min_price = $this->temp_min_price;
        $this->max_price = $this->temp_max_price;
        $this->sort = $this->temp_sort;
        $this->showFilter = false;
        $this->selectedKategori = $this->temp_selectedKategori;
        $this->resetPage();
    }

    public function toggleFilter()
    {
        $this->showFilter = !$this->showFilter;
    }

    public function render()
    {
        $query = Produk::query();

        if ($this->search) {
            $query->where('nama', 'like', '%' . $this->search . '%');
        }

        if ($this->selectedKategori) {
            $query->where('kategori_id', $this->selectedKategori);
        }

        if ($this->min_price) {
            $query->where('harga', '>=', $this->min_price);
        }

        if ($this->max_price) {
            $query->where('harga', '<=', $this->max_price);
        }

        if ($this->sort == 'priceLow') {
            $query->orderBy('harga', 'asc');
        } elseif ($this->sort == 'priceHigh') {
            $query->orderBy('harga', 'desc');
        }

        $produks = $query->paginate(10);

        return view('livewire.kwu.landing.beranda-component', compact('produks'));
    }
}
