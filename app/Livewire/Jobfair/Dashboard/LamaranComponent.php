<?php

namespace App\Livewire\Jobfair\Dashboard;

use Livewire\Component;
use App\Models\Perusahaan;
use Livewire\WithPagination;
use App\Models\MelamarPekerjaan;

class LamaranComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'tailwind';

    public $status;
    public $isOpen = false;
    public $selected_id = null;
    public $deleteId = null;
    public $search = '';

    protected $rules = [
        'status' => 'required',
    ];

    public function create()
    {
        $this->resetInput();
        $this->openModal();
    }

    public function edit($id)
    {
        $lamaran = MelamarPekerjaan::findOrFail($id);
        $this->status = $lamaran->status;
        $this->selected_id = $id;

        $this->openModal();
    }

    public function store()
    {
        $this->validate();

        $lamaran = MelamarPekerjaan::findOrFail($this->selected_id);
        $lamaran->update(
            [
                'status' => $this->status,
            ]
        );

        session()->flash('message', 'Data berhasil diperbarui.');

        $this->closeModal();
        $this->resetInput();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDelete($id)
    {
        $this->selected_id = $id;
        $this->deleteId = $id;
    }

    public function delete()
    {
        MelamarPekerjaan::findOrFail($this->selected_id)->delete();
        session()->flash('message', 'Data berhasil dihapus.');
        $this->deleteId = null;
    }

    private function resetInput()
    {
        $this->status = null;
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
        $query = MelamarPekerjaan::with('pekerjaan', 'pelamar')
            ->when($this->search, function ($q) {
                $search = $this->search;
                $q->where(function ($query) use ($search) {
                    $query->whereHas('pekerjaan', fn($sub) => $sub->where('judul', 'like', "%$search%"))
                        ->orWhereHas('pelamar', fn($sub) => $sub->where('nama_lengkap', 'like', "%$search%"))
                        ->orWhere('status', 'like', "%$search%");
                });
            })
            ->latest();

        $lamarans = $query->paginate(10);

        return view('livewire.jobfair.dashboard.lamaran-component', compact('lamarans'));
    }
}
