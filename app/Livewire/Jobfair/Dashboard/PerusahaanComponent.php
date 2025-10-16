<?php

namespace App\Livewire\Jobfair\Dashboard;

use App\Models\Perusahaan;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;

class PerusahaanComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'tailwind';

    public $nama, $alamat, $jenis_perusahaan;
    public $perusahaan_id;
    public $isOpen = false;
    public $deleteId = null;
    public $search = '';

    protected $rules = [
        'nama' => 'required|string|max:255',
        'alamat' => 'required|string|max:255',
        'jenis_perusahaan' => 'required|in:pt,cv,ud',
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
        $perusahaan = Perusahaan::findOrFail($id);
        $this->perusahaan_id = $id;
        $this->nama = $perusahaan->nama;
        $this->alamat = $perusahaan->alamat;
        $this->jenis_perusahaan = $perusahaan->jenis_perusahaan;

        $this->openModal();
    }

    public function store()
    {
        $this->validate();

        Perusahaan::updateOrCreate(
            ['id' => $this->perusahaan_id],
            [
                'nama' => $this->nama,
                'alamat' => $this->alamat,
                'jenis_perusahaan' => $this->jenis_perusahaan,
            ]
        );

        session()->flash(
            'message',
            $this->perusahaan_id ? 'Perusahaan berhasil diperbarui.' : 'Perusahaan berhasil ditambahkan.'
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
        Perusahaan::findOrFail($this->deleteId)->delete();
        session()->flash('message', 'Perusahaan berhasil dihapus.');
        $this->deleteId = null;
    }

    private function resetInput()
    {
        $this->nama = '';
        $this->alamat = '';
        $this->jenis_perusahaan = '';
        $this->perusahaan_id = null;
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
        $perusahaans = Perusahaan::query()
            ->when($this->search, function ($q) {
                $q->where('nama', 'like', '%' . $this->search . '%')
                    ->orWhere('alamat', 'like', '%' . $this->search . '%')
                    ->orWhere('jenis_perusahaan', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.jobfair.dashboard.perusahaan-component', compact('perusahaans'));
    }
}
