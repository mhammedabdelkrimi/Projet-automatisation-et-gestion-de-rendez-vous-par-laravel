<tr class="clickable-row" onclick="openDetailAppointmentModal({{ json_encode($rdv) }})">
    <td class="font-bold">{{ $rdv->firstname }} {{ $rdv->lastname }}</td>
    <td>
        <div class="date-time-cell">
            <span class="date">{{ \Carbon\Carbon::parse($rdv->date)->format('d/m/Y') }}</span>
            <span class="time">{{ \Carbon\Carbon::parse($rdv->time)->format('H:i') }}</span>
        </div>
    </td>
    <td>{{ $rdv->phone }}</td>
    <td>
        @php
            $servicesArr = is_string($rdv->services) ? json_decode($rdv->services, true) : $rdv->services;
        @endphp
        @if(is_array($servicesArr) && count($servicesArr) > 0)
            <div class="badges-wrapper" style="display: flex; flex-wrap: wrap; gap: 4px;">
                @foreach($servicesArr as $s)
                    <span class="badge badge-teal">{{ $s }}</span>
                @endforeach
            </div>
        @else
            <span class="text-gray">-</span>
        @endif
    </td>
    <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
        {{ $rdv->description ?? '-' }}
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
