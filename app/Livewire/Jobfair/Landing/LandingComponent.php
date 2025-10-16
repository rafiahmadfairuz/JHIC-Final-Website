<?php

namespace App\Livewire\Jobfair\Landing;

use Livewire\Component;
use App\Models\Pekerjaan;
use App\Models\Perusahaan;
use Livewire\WithPagination;

class LandingComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'tailwind';

    public $selected_id;

    #[Url(as: 'q')]
    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $pekerjaans = Pekerjaan::with('perusahaan')
            ->where('judul', 'like', '%' . $this->search . '%')
            ->orWhereHas('perusahaan', function ($query) {
                $query->where('nama', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);
        return view('livewire.jobfair.landing.landing-component', compact('pekerjaans'));
    }
}
