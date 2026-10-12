<?php

namespace App\Modules\Recruitment\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Recruitment\Actions\MoveToTalentPool;
use App\Modules\Recruitment\Models\Candidate;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TalentPoolController extends Controller
{
    public function index(Request $request): View
    {
        $q = $request->query('q');

        $items = Candidate::where('is_talent_pool', true)
            ->with('source')
            ->when($q, fn ($c) => $c->where(fn ($w) => $w
                ->where('name', 'like', "%{$q}%")
                ->orWhere('city', 'like', "%{$q}%")
                ->orWhere('education', 'like', "%{$q}%")))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('recruitment.talent-pool.TalentPool', [
            'items' => $items,
            'q' => $q,
        ]);
    }

    public function add(Request $request, MoveToTalentPool $action): RedirectResponse
    {
        $data = $request->validate([
            'candidate_id' => ['required', 'exists:recruitment_candidates,id'],
            'tags' => ['nullable', 'string', 'max:500'],
        ], [
            'candidate_id.required' => __('Kandidat wajib dipilih.'),
            'candidate_id.exists' => __('Kandidat tidak valid.'),
            'tags.max' => __('Tag maksimal :max karakter.'),
        ]);

        $candidate = Candidate::findOrFail($data['candidate_id']);
        $tags = array_map('trim', explode(',', $data['tags'] ?? ''));

        $action->execute($candidate, true, $tags);

        return back()->with('rc_msg', __('Kandidat dimasukkan ke talent pool.'));
    }

    public function remove(Candidate $candidate, MoveToTalentPool $action): RedirectResponse
    {
        $action->execute($candidate, false);

        return back()->with('rc_msg', __('Kandidat dikeluarkan dari talent pool.'));
    }
}
