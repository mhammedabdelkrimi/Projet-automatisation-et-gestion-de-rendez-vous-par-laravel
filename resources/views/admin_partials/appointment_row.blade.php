<tr class="appointment-row clickable-row" data-id="{{ $rdv->id }}" data-search="{{ strtolower($rdv->firstname . ' ' . $rdv->lastname . ' ' . $rdv->phone . ' ' . $rdv->email) }}" onclick="openDetailAppointmentModal({{ json_encode($rdv) }})">
    <td class="font-bold">
        <div>{{ $rdv->firstname }} {{ $rdv->lastname }}</div>
        <div class="patient-details" style="font-weight: normal; font-size: 0.8rem; color: var(--text-gray); margin-top: 4px;">
            <span>{{ $rdv->age }} ans / {{ $rdv->gender === 'homme' ? 'Homme' : 'Femme' }}</span>
        </div>
    </td>
    <td>
        <div class="contact-details">
            <span class="phone">{{ $rdv->phone }}</span>
            <span class="email" style="font-size: 0.82rem; color: var(--text-gray);">{{ $rdv->email ?? '-' }}</span>
        </div>
    </td>
    <td>
        <div class="date-time-cell">
            <span class="date">{{ \Carbon\Carbon::parse($rdv->date)->format('d/m/Y') }}</span>
            <span class="time">{{ \Carbon\Carbon::parse($rdv->time)->format('H:i') }}</span>
        </div>
    </td>
    <td>
        @php
            $servicesArr = is_string($rdv->services) ? json_decode($rdv->services, true) : $rdv->services;
        @endphp
        @if(is_array($servicesArr) && count($servicesArr) > 0)
            <div class="badges-wrapper" style="display: flex; flex-direction: column; gap: 4px;">
                @foreach(array_slice($servicesArr, 0, 1) as $s)
                    <span class="badge badge-teal" style="white-space: nowrap; max-width: 160px; overflow: hidden; text-overflow: ellipsis; display: inline-block;" title="{{ $s }}">{{ $s }}</span>
                @endforeach
                @if(count($servicesArr) > 1)
                    <span class="badge badge-teal" style="width: fit-content; font-size: 0.72rem;">+{{ count($servicesArr) - 1 }} service(s)</span>
                @endif
            </div>
        @else
            <span class="text-gray">-</span>
        @endif
    </td>
    <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
        {{ $rdv->description ?? '-' }}
    </td>
    <td>
        @if($rdv->status === 'accepte')
            <span class="status-badge status-accepted">
                <span class="fr">Accepté</span>
                <span class="ar">مقبول</span>
            </span>
        @elseif($rdv->status === 'annule')
            <span class="status-badge status-cancelled">
                <span class="fr">Annulé</span>
                <span class="ar">ملغى</span>
            </span>
        @else
            <span class="status-badge status-pending">
                <span class="fr">En attente</span>
                <span class="ar">قيد الانتظار</span>
            </span>
        @endif
    </td>
    <td>
        @php
            $isRecent = $rdv->created_at->greaterThanOrEqualTo(\Carbon\Carbon::now()->subHours(24));
        @endphp
        <span class="validity-indicator {{ $isRecent ? 'validity-future' : 'validity-past' }}" title="{{ $isRecent ? 'Récent (Dernières 24h)' : 'Ancien' }}">
            <span class="dot"></span>
            <span class="fr">{{ $isRecent ? 'Récent' : 'Ancien' }}</span>
            <span class="ar">{{ $isRecent ? 'حديث' : 'قديم' }}</span>
        </span>
    </td>
</tr>
