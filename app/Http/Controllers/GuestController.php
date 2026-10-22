<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class GuestController extends Controller
{
    public function dashboard()
    {
        $total = Guest::count();

        $checkedIn = Guest::whereNotNull('checked_in_at')->count();

        $expectedPeople = (int) Guest::sum('guest_count');

        $arrivedPeople = (int) Guest::whereNotNull('checked_in_at')
            ->sum('guest_count');

        $recentGuests = Guest::latest()->take(8)->get();

        return view('dashboard', compact(
            'total',
            'checkedIn',
            'expectedPeople',
            'arrivedPeople',
            'recentGuests'
        ));
    }

    public function index(Request $request)
    {
        $query = Guest::query();

        if ($search = trim((string) $request->query('search'))) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('table_number', 'like', "%{$search}%");
            });
        }

        if ($side = $request->query('side')) {
            if (in_array($side, ['bride', 'groom', 'both'], true)) {
                $query->where('guest_side', $side);
            }
        }

        if ($status = $request->query('status')) {
            if ($status === 'checked_in') {
                $query->whereNotNull('checked_in_at');
            } elseif ($status === 'not_arrived') {
                $query->whereNull('checked_in_at');
            }
        }

        $guests = $query->latest()
            ->paginate(15)
            ->withQueryString();

        return view('guests.index', compact('guests'));
    }

    public function create()
    {
        return view('guests.create', [
            'guest' => new Guest(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        // Default RSVP status if the form does not send one.
        $data['rsvp_status'] = $data['rsvp_status'] ?? 'pending';

        Guest::create($data);

        return redirect()
            ->route('guests.index')
            ->with('success', __('wedding.guest_added'));
    }

    public function show(Guest $guest)
    {
        return view('guests.show', compact('guest'));
    }

    public function edit(Guest $guest)
    {
        return view('guests.edit', compact('guest'));
    }

    public function update(Request $request, Guest $guest)
    {
        $data = $this->validated($request);

        // Preserve the existing RSVP status if an edit form omits it.
        $data['rsvp_status'] = $data['rsvp_status']
            ?? $guest->rsvp_status
            ?? 'pending';

        $guest->update($data);

        return redirect()
            ->route('guests.show', $guest)
            ->with('success', __('wedding.guest_updated'));
    }

    public function destroy(Guest $guest)
    {
        $guest->delete();

        return redirect()
            ->route('guests.index')
            ->with('success', __('wedding.guest_deleted'));
    }

    public function checkin(Guest $guest)
    {
        if (!$guest->checked_in_at) {
            $guest->update([
                'checked_in_at' => now(),
            ]);
        }

        return back()->with(
            'success',
            __('wedding.checked_in_success')
        );
    }

    public function undoCheckin(Guest $guest)
    {
        $guest->update([
            'checked_in_at' => null,
        ]);

        return back()->with(
            'success',
            __('wedding.checkin_undone')
        );
    }

    public function reports()
    {
        $totalGuests = Guest::count();

        $checkedIn = Guest::whereNotNull('checked_in_at')->count();

        $notArrived = Guest::whereNull('checked_in_at')->count();

        $peopleExpected = (int) Guest::sum('guest_count');

        $peopleArrived = (int) Guest::whereNotNull('checked_in_at')
            ->sum('guest_count');

        $bySide = Guest::selectRaw(
            'guest_side, COUNT(*) as total, SUM(guest_count) as people'
        )
            ->groupBy('guest_side')
            ->get();

        return view('reports.index', compact(
            'totalGuests',
            'checkedIn',
            'notArrived',
            'peopleExpected',
            'peopleArrived',
            'bySide'
        ));
    }

    public function exportCsv(): StreamedResponse
    {
        $filename = 'wedding-guests-' . now()->format('Y-m-d-His') . '.csv';

        $guests = Guest::orderBy('full_name')->get();

        return response()->streamDownload(function () use ($guests) {
            $handle = fopen('php://output', 'w');

            // UTF-8 BOM helps Microsoft Excel display Khmer correctly.
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'Name',
                'Phone',
                'Side',
                'Table',
                'Guest Count',
                'RSVP',
                'Check-in Time',
                'Notes',
            ]);

            foreach ($guests as $guest) {
                fputcsv($handle, [
                    $guest->full_name,
                    $guest->phone,
                    $guest->guest_side,
                    $guest->table_number,
                    $guest->guest_count,
                    $guest->rsvp_status,
                    optional($guest->checked_in_at)->format('Y-m-d H:i:s'),
                    $guest->notes,
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'full_name' => [
                'required',
                'string',
                'max:150',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:40',
            ],

            'guest_side' => [
                'required',
                'in:bride,groom,both',
            ],

            'table_number' => [
                'nullable',
                'string',
                'max:30',
            ],

            'guest_count' => [
                'required',
                'integer',
                'min:1',
                'max:50',
            ],

            // RSVP is optional in the form; store() supplies "pending".
            'rsvp_status' => [
                'sometimes',
                'nullable',
                'in:pending,confirmed,declined',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);
    }
}
