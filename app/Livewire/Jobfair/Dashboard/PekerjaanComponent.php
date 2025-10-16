<?php

namespace App\Livewire\Jobfair\Dashboard;

use Livewire\Component;
use App\Models\Pekerjaan;
use App\Models\Perusahaan;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class PekerjaanComponent extends Component
{
    use WithPagination, WithFileUploads;
    protected $paginationTheme = 'tailwind';

    public $perusahaan_id, $judul, $deskripsi, $syarat, $batas, $lokasi, $poster, $status;
    public $pekerjaan_id;
    public $isOpen = false;
    public $deleteId = null;
    public $search = '';


    protected $rules = [
        'judul' => 'required|string|max:255',
        'lokasi' => 'required|string|max:255',
        'deskripsi' => 'required|string',
        'syarat' => 'required|string',
        'batas' => 'required|date',
        'perusahaan_id' => 'required|exists:perusahaans,id',
        'status' => 'required|in:aktif,tutup',
        'poster' => 'nullable|image|max:2048',
    ];


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->resetInput();
        $this->openModal();
    }

    public function edit($id)
    {
        $p = Pekerjaan::findOrFail($id);
        $this->pekerjaan_id = $id;
        $this->perusahaan_id = $p->perusahaan_id;
        $this->judul = $p->judul;
        $this->deskripsi = $p->deskripsi;
        $this->syarat = $p->syarat;
        $this->batas = $p->batas;
        $this->lokasi = $p->lokasi;
        $this->status = $p->status;
        $this->poster = null;

        $this->openModal();
    }

    public function store()
    {
        $this->validate();

        $data = [
            'admin_bkk_id' => 1,
            'perusahaan_id' => $this->perusahaan_id,
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi,
            'syarat' => $this->syarat,
            'batas' => $this->batas,
            'lokasi' => $this->lokasi,
            'status' => $this->status,
        ];

        if ($this->poster) {
            $data['poster'] = $this->poster->store('posters', 'public');
        }

        Pekerjaan::updateOrCreate(['id' => $this->pekerjaan_id], $data);

        session()->flash(
            'message',
            $this->pekerjaan_id ? 'Pekerjaan berhasil diperbarui.' : 'Pekerjaan berhasil ditambahkan.'
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
        Pekerjaan::findOrFail($this->deleteId)->delete();
        session()->flash('message', 'Pekerjaan berhasil dihapus.');
        $this->deleteId = null;
    }

    private function resetInput()
    {
        $this->perusahaan_id = '';
        $this->judul = '';
        $this->deskripsi = '';
        $this->syarat = '';
        $this->batas = '';
        $this->lokasi = '';
        $this->poster = null;
        $this->status = '';
        $this->pekerjaan_id = null;
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
        $query = Pekerjaan::with('perusahaan')
            ->when($this->search, function ($q) {
                $q->where('judul', 'like', '%' . $this->search . '%')
                    ->orWhere('lokasi', 'like', '%' . $this->search . '%')
                    ->orWhereHas('perusahaan', function ($sub) {
                        $sub->where('nama', 'like', '%' . $this->search . '%');
                    });
            })
            ->latest();

        return view('livewire.jobfair.dashboard.pekerjaan-component', [
            'pekerjaans' => $query->paginate(5),
            'perusahaans' => Perusahaan::all(),
        ]);
    }

}
