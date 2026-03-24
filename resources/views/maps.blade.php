<x-app-layout>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css"/>

@php
    $user = auth()->user();
    $currentStatus = $user->status ?? 'offline';
@endphp

<style>
    :root {
        --maps-top-offset: calc(110px + env(safe-area-inset-top, 0px));
        --maps-bottom-offset: calc(140px + env(safe-area-inset-bottom, 0px));
    }

    .maps-wrap,
    .maps-wrap *,
    .maps-map-card,
    .maps-map-card * {
        box-sizing: border-box;
    }

    body { font-family: 'Inter', sans-serif; background: var(--app-bg); color: var(--app-text); -webkit-tap-highlight-color: transparent; }

    .maps-wrap {
        min-height: 100dvh;
        background:
            radial-gradient(circle at top, color-mix(in srgb, var(--app-accent) 10%, transparent), transparent 38%),
            linear-gradient(180deg, #f3f6fb 0%, var(--app-bg-soft) 100%);
        padding: 34px 16px 28px;
        color: var(--app-text);
    }

    html[data-theme="dark"] .maps-wrap {
        background:
            radial-gradient(circle at top, color-mix(in srgb, var(--app-accent) 10%, transparent), transparent 38%),
            linear-gradient(180deg, var(--app-bg) 0%, var(--app-bg-soft) 100%);
    }

    .maps-shell {
        max-width: 1220px;
        margin: 0 auto;
        display: block;
    }

    .maps-panel,
    .maps-map-card {
        border: 1px solid rgba(148, 163, 184, 0.18);
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 24px 60px rgba(15, 23, 42, 0.08);
    }

    .maps-panel { display: none; }

    html[data-theme="dark"] .maps-panel,
    html[data-theme="dark"] .maps-map-card {
        background: color-mix(in srgb, var(--app-surface) 96%, transparent);
        border-color: var(--app-border);
        box-shadow: var(--app-shadow);
    }

    .maps-kicker,
    .maps-label,
    .maps-meta {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 0.68rem;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--app-text-muted);
    }

    .maps-title {
        margin-top: 10px;
        font-size: clamp(1.9rem, 3.6vw, 3rem);
        line-height: 0.98;
        letter-spacing: -0.05em;
        font-weight: 700;
        color: var(--app-text);
        max-width: 10ch;
    }

    .maps-copy {
        margin-top: 14px;
        color: var(--app-text-soft);
        font-size: 0.96rem;
        line-height: 1.75;
    }

    .maps-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .maps-btn,
    .maps-mini-btn {
        border: 1px solid transparent;
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .maps-btn {
        min-height: 50px;
        padding: 0 18px;
        border-radius: 16px;
        font-size: 0.84rem;
    }

    .maps-btn.primary { background: #0f172a; color: #ffffff; }
    .maps-btn.secondary { background: rgba(255,255,255,0.92); border-color: rgba(148, 163, 184, 0.2); color: #334155; }
    html[data-theme="dark"] .maps-btn.secondary { background: var(--app-surface-strong); border-color: var(--app-border); color: var(--app-text-soft); }

    .maps-stats { display: grid; gap: 12px; }
    .maps-stat {
        border-radius: 18px;
        border: 1px solid rgba(148, 163, 184, 0.18);
        background: rgba(255,255,255,0.82);
        padding: 16px;
    }
    html[data-theme="dark"] .maps-stat { border-color: var(--app-border); background: var(--app-surface-strong); }
    .maps-value {
        margin-top: 8px;
        font-size: 1rem;
        font-weight: 700;
        color: var(--app-text);
        word-break: break-word;
    }

    .maps-map-card {
        position: relative;
        min-height: calc(100dvh - 118px);
        margin-top: 84px;
        background: #f8fafc;
        isolation: isolate;
    }

    #liveMapCanvas {
        width: 100%;
        height: calc(100dvh - 118px);
        min-height: 700px;
        background: #f8fafc;
    }

    .maps-overlay {
        position: absolute;
        z-index: 650;
        background: rgba(255,255,255,0.9);
        border: 1px solid rgba(148, 163, 184, 0.18);
        box-shadow: 0 16px 38px rgba(15, 23, 42, 0.08);
        backdrop-filter: blur(18px);
    }

    html[data-theme="dark"] .maps-overlay {
        background: color-mix(in srgb, var(--app-surface) 96%, transparent);
        border-color: var(--app-border);
        box-shadow: var(--app-shadow);
    }

    /* ✅ KEY FIX: top: 16px instead of var(--maps-top-offset) */
    .maps-topbar {
        top: 16px;
        left: 16px;
        right: auto;
        width: min(760px, calc(100% - 32px));
        border-radius: 22px;
        padding: 14px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }

    .maps-map-card.is-fullscreen .maps-topbar {
        top: calc(18px + env(safe-area-inset-top, 0px));
        left: 18px;
        right: 18px;
        border-radius: 20px;
        padding: 12px 14px;
    }

    .maps-map-card.is-fullscreen .maps-footer {
        left: 18px;
        right: 18px;
        bottom: calc(22px + env(safe-area-inset-bottom, 0px));
        border-radius: 20px;
    }

    .maps-map-card.is-fullscreen .maps-location-fab {
        right: 18px;
        bottom: calc(98px + env(safe-area-inset-bottom, 0px));
    }

    .maps-map-title {
        font-size: 0.98rem;
        font-weight: 700;
        color: var(--app-text);
    }

    .maps-topbar-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .maps-mini-btn {
        min-height: 38px;
        padding: 0 14px;
        border-radius: 12px;
        border-color: rgba(148, 163, 184, 0.2);
        background: rgba(255,255,255,0.96);
        color: #334155;
        font-size: 0.78rem;
    }

    html[data-theme="dark"] .maps-mini-btn {
        background: var(--app-surface-strong);
        border-color: var(--app-border);
        color: var(--app-text-soft);
    }

    .maps-chip {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        min-height: 34px;
        padding: 0 12px;
        border-radius: 999px;
        border: 1px solid rgba(148, 163, 184, 0.2);
        background: #ffffff;
        color: var(--app-text-muted);
        font-family: 'IBM Plex Mono', monospace;
        font-size: 0.66rem;
        letter-spacing: 0.1em;
        text-transform: uppercase;
    }

    .maps-chip.online { background: #ecfdf5; border-color: #a7f3d0; color: #047857; }
    .maps-chip-dot { width: 7px; height: 7px; border-radius: 50%; background: currentColor; }

    .maps-location-fab {
        position: absolute;
        right: 16px;
        bottom: 96px;
        z-index: 680;
        width: 52px;
        height: 52px;
        border-radius: 18px;
        border: 1px solid rgba(148, 163, 184, 0.18);
        background: rgba(255,255,255,0.96);
        box-shadow: 0 16px 38px rgba(15, 23, 42, 0.08);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #0f172a;
        cursor: pointer;
        backdrop-filter: blur(18px);
    }

    .maps-location-fab svg { width: 22px; height: 22px; }
    html[data-theme="dark"] .maps-location-fab { background: var(--app-surface-strong); border-color: var(--app-border); color: var(--app-text); box-shadow: var(--app-shadow); }

    .maps-footer {
        left: 16px;
        right: auto;
        width: min(560px, calc(100% - 96px));
        bottom: 16px;
        border-radius: 22px;
        padding: 14px 16px;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 12px;
        flex-wrap: wrap;
    }

    .maps-footer-text {
        color: var(--app-text);
        font-weight: 700;
        font-size: 0.88rem;
        line-height: 1.4;
    }

    .leaflet-container { font-family: 'Inter', sans-serif !important; background: #f8fafc !important; }
    .leaflet-pane,
    .leaflet-control-container,
    .leaflet-top,
    .leaflet-bottom {
        z-index: 1;
    }
    .leaflet-control-attribution { display: none !important; }
    .leaflet-control-zoom { display: none !important; }
    .leaflet-popup-content-wrapper {
        background: rgba(255,255,255,0.96) !important;
        border: 1px solid rgba(148, 163, 184, 0.18) !important;
        border-radius: 18px !important;
        box-shadow: 0 18px 38px rgba(15, 23, 42, 0.08) !important;
        color: var(--app-text) !important;
        font-family: 'Inter', sans-serif !important;
    }
    html[data-theme="dark"] .leaflet-popup-content-wrapper { background: color-mix(in srgb, var(--app-surface) 96%, transparent) !important; border-color: var(--app-border) !important; box-shadow: var(--app-shadow) !important; }
    .leaflet-popup-tip { background: rgba(255,255,255,0.96) !important; }
    html[data-theme="dark"] .leaflet-popup-tip { background: color-mix(in srgb, var(--app-surface) 96%, transparent) !important; }

    @media (max-width: 720px) {
        :root {
            --maps-top-offset: calc(102px + env(safe-area-inset-top, 0px));
            --maps-bottom-offset: calc(172px + env(safe-area-inset-bottom, 0px));
        }

        .maps-wrap { padding: 0; }
        .maps-map-card {
            min-height: 100dvh;
            margin-top: 0;
            border-radius: 0;
            border-left: 0;
            border-right: 0;
            border-top: 0;
        }
        #liveMapCanvas {
            min-height: 100dvh;
            height: 100dvh;
        }
        .maps-topbar,
        .maps-footer {
            left: 12px;
            right: 12px;
            width: auto;
        }
        /* ✅ On mobile the topbar is fixed so it needs the nav offset */
        .maps-topbar {
            position: fixed;
            top: var(--maps-top-offset);
            z-index: 2050;
        }
        .maps-footer {
            position: fixed;
            bottom: calc(var(--maps-bottom-offset) - 28px);
            z-index: 2050;
        }
        .maps-location-fab {
            position: fixed;
            right: 12px;
            bottom: calc(var(--maps-bottom-offset) + 34px);
            z-index: 2060;
        }
        .maps-footer {
            padding: 12px 16px;
            min-height: 62px;
        }
        .maps-footer-text {
            font-size: 0.8rem;
        }

        .maps-map-card.is-fullscreen .maps-topbar {
            top: calc(10px + env(safe-area-inset-top, 0px));
            left: 10px;
            right: 10px;
            width: auto;
            padding: 12px;
            gap: 10px;
        }

        .maps-map-card.is-fullscreen .maps-topbar-actions {
            width: 100%;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px;
        }

        .maps-map-card.is-fullscreen .maps-mini-btn,
        .maps-map-card.is-fullscreen .maps-chip {
            width: 100%;
            justify-content: center;
            min-height: 40px;
        }

        .maps-map-card.is-fullscreen .maps-footer {
            left: 10px;
            right: 10px;
            width: auto;
            bottom: calc(10px + env(safe-area-inset-bottom, 0px));
            min-height: 58px;
        }

        .maps-map-card.is-fullscreen .maps-location-fab {
            right: 10px;
            bottom: calc(104px + env(safe-area-inset-bottom, 0px));
        }
    }
</style>

<div class="maps-wrap">
    <div class="maps-shell">
        <aside class="maps-panel">
            <div>
                <div class="maps-kicker">Maps workspace</div>
                <h1 class="maps-title">Current vehicle location, ready for Traccar later.</h1>
                <p class="maps-copy">This screen fetches the phone's current location, shows it on a large Leaflet map, and keeps the UI ready for live Traccar vehicle data once you wire it in.</p>
            </div>

            <div class="maps-actions">
                <button type="button" class="maps-btn primary" id="requestLocationButton">Enable Live Location</button>
                <button type="button" class="maps-btn secondary" id="centerMapButton">Center Map</button>
            </div>

            <div class="maps-stats">
                <div class="maps-stat"><div class="maps-label">Tracking Status</div><div class="maps-value" id="locationTrackingState">{{ $currentStatus === 'online' ? 'Tracking enabled' : 'Tracking disabled' }}</div></div>
                <div class="maps-stat"><div class="maps-label">Latitude</div><div class="maps-value" id="locationLatitude">{{ $user->latitude !== null ? number_format((float) $user->latitude, 6) : 'Waiting for permission' }}</div></div>
                <div class="maps-stat"><div class="maps-label">Longitude</div><div class="maps-value" id="locationLongitude">{{ $user->longitude !== null ? number_format((float) $user->longitude, 6) : 'Waiting for permission' }}</div></div>
                <div class="maps-stat"><div class="maps-label">Accuracy</div><div class="maps-value" id="locationAccuracy">{{ $user->location_accuracy !== null ? round((float) $user->location_accuracy) . ' m' : 'Unknown' }}</div></div>
                <div class="maps-stat"><div class="maps-label">Last Updated</div><div class="maps-value" id="locationUpdated">{{ $user->location_updated_at ? $user->location_updated_at->diffForHumans() : 'Not synced yet' }}</div></div>
                <div class="maps-stat"><div class="maps-label">Current Location</div><div class="maps-value" id="locationLabel">{{ $user->latitude !== null && $user->longitude !== null ? 'Latest device position saved' : 'Location inactive' }}</div></div>
            </div>
        </aside>

        <section class="maps-map-card">
            <div class="maps-topbar maps-overlay">
                <div>
                    <div class="maps-map-title">Live Location Map</div>
                    <div class="maps-meta">Current device position</div>
                </div>
                <div class="maps-topbar-actions">
                    <button type="button" class="maps-mini-btn" id="mapEnableLiveLocation">Enable Live Location</button>
                    <button type="button" class="maps-mini-btn" id="fullscreenMapButton">Full Screen</button>
                    <div class="maps-chip {{ $currentStatus === 'online' ? 'online' : '' }}" id="mapsStatusChip">
                        <span class="maps-chip-dot"></span>
                        <span id="mapsStatusText">{{ $currentStatus === 'online' ? 'Tracking live' : 'Tracking idle' }}</span>
                    </div>
                </div>
            </div>

            <div id="liveMapCanvas"></div>

            <button type="button" class="maps-location-fab" id="currentLocationFab" aria-label="Current location">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3v3m0 12v3m9-9h-3M6 12H3m9 4a4 4 0 100-8 4 4 0 000 8z"/></svg>
            </button>

            <div class="maps-footer maps-overlay">
                <div>
                    <div class="maps-meta">Current position</div>
                    <div class="maps-footer-text" id="mapFooterMeta">Open the app on your phone and allow location access to start live updates.</div>
                </div>
            </div>
        </section>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
<script>
    const MAX_ACCEPTABLE_ACCURACY = 500;
    const locationState = {
        status: @json($currentStatus),
        latitude: {{ $user->latitude !== null ? (float) $user->latitude : 'null' }},
        longitude: {{ $user->longitude !== null ? (float) $user->longitude : 'null' }},
        accuracy: {{ $user->location_accuracy !== null ? (float) $user->location_accuracy : 'null' }},
    };

    let liveMap = null;
    let liveMarker = null;
    let watchId = null;
    let isLocationSyncing = false;

    function buildMarker(isOnline) {
        return L.divIcon({
            className: '',
            html: `<div style="width:40px;height:40px;border-radius:50%;background:${isOnline ? '#16a34a' : '#64748b'};border:4px solid rgba(255,255,255,0.95);box-shadow:0 12px 28px rgba(15,23,42,0.18);display:flex;align-items:center;justify-content:center;color:white;font-size:1rem;">•</div>`,
            iconSize: [40, 40],
            iconAnchor: [20, 20],
            popupAnchor: [0, -20],
        });
    }

    function popupHtml() {
        const isOnline = locationState.status === 'online';
        return `
            <div style="font-weight:700; margin-bottom:4px;">{{ auth()->user()->name }}</div>
            <div style="font-size:0.82rem; color:var(--app-text-soft);">${isOnline ? 'Tracking enabled' : 'Tracking disabled'}</div>
            <div style="margin-top:4px; font-family:'IBM Plex Mono', monospace; font-size:0.72rem; color:var(--app-text-muted);">
                ${locationState.latitude.toFixed(6)}, ${locationState.longitude.toFixed(6)}
            </div>
        `;
    }

    function syncLocationUi() {
        const hasLocation = locationState.latitude !== null && locationState.longitude !== null;
        const isOnline = locationState.status === 'online';
        const goodFix = hasLocation && (!locationState.accuracy || locationState.accuracy <= MAX_ACCEPTABLE_ACCURACY);
        const accuracyText = locationState.accuracy ? `${Math.round(locationState.accuracy)} m` : 'Unknown';

        document.getElementById('locationTrackingState').textContent = isOnline ? 'Tracking enabled' : 'Tracking disabled';
        document.getElementById('mapsStatusText').textContent = isOnline ? 'Tracking live' : 'Tracking idle';
        document.getElementById('mapsStatusChip').classList.toggle('online', isOnline);
        document.getElementById('locationLatitude').textContent = hasLocation ? locationState.latitude.toFixed(6) : 'Waiting for permission';
        document.getElementById('locationLongitude').textContent = hasLocation ? locationState.longitude.toFixed(6) : 'Waiting for permission';
        document.getElementById('locationAccuracy').textContent = accuracyText;
        document.getElementById('locationUpdated').textContent = goodFix ? 'Just now' : hasLocation ? 'Waiting for better GPS fix' : 'Not synced yet';
        document.getElementById('locationLabel').textContent = goodFix ? 'Latest device position saved' : hasLocation ? 'Low-precision location found' : 'Location inactive';
        document.getElementById('mapFooterMeta').textContent = goodFix
            ? `Position synced with ${accuracyText} accuracy`
            : hasLocation
                ? `Weak GPS signal at ${accuracyText}, waiting for a better fix`
                : 'Open the app on your phone and allow location access to start live updates.';

        if (hasLocation && liveMap) {
            if (!liveMarker) {
                liveMarker = L.marker([locationState.latitude, locationState.longitude], { icon: buildMarker(isOnline) }).addTo(liveMap);
            } else {
                liveMarker.setLatLng([locationState.latitude, locationState.longitude]);
                liveMarker.setIcon(buildMarker(isOnline));
            }
            liveMarker.bindPopup(popupHtml());
        }
    }

    function setLocationSyncing(syncing, label = null) {
        isLocationSyncing = syncing;
        const topButton = document.getElementById('mapEnableLiveLocation');
        const sideButton = document.getElementById('requestLocationButton');

        if (topButton) {
            topButton.textContent = label ?? (syncing ? 'Syncing...' : 'Enable Live Location');
            topButton.disabled = syncing;
            topButton.style.opacity = syncing ? '0.72' : '1';
        }

        if (sideButton) {
            sideButton.textContent = label ?? (syncing ? 'Syncing...' : 'Enable Live Location');
            sideButton.disabled = syncing;
            sideButton.style.opacity = syncing ? '0.72' : '1';
        }
    }

    async function saveLocation(position) {
        setLocationSyncing(true, 'Syncing...');
        locationState.latitude = position.coords.latitude;
        locationState.longitude = position.coords.longitude;
        locationState.accuracy = position.coords.accuracy || null;
        syncLocationUi();

        if (liveMap) {
            liveMap.setView([locationState.latitude, locationState.longitude], 16);
        }

        if (locationState.accuracy && locationState.accuracy > MAX_ACCEPTABLE_ACCURACY) {
            setLocationSyncing(false, 'Weak GPS');
            return;
        }

        try {
            await fetch('{{ route('location.update') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    latitude: locationState.latitude,
                    longitude: locationState.longitude,
                    accuracy: locationState.accuracy,
                }),
            });
            setLocationSyncing(false, 'Live Location On');
        } catch (error) {
            console.warn('[Maps] Location update failed', error);
            setLocationSyncing(false, 'Try Again');
        }
    }

    function handleLocationError(error) {
        setLocationSyncing(false, 'Enable Live Location');
        const label = document.getElementById('locationLabel');
        const footer = document.getElementById('mapFooterMeta');

        if (error?.code === 1) {
            label.textContent = 'Location permission blocked';
            footer.textContent = 'Allow location access in browser or PWA settings, then try again.';
            return;
        }
        if (error?.code === 2) {
            label.textContent = 'Location unavailable';
            footer.textContent = 'Your device could not get a GPS fix yet. Try going outside or enabling precise location.';
            return;
        }
        if (error?.code === 3) {
            label.textContent = 'Location request timed out';
            footer.textContent = 'The device took too long to get a GPS fix. Try again and keep the app open a little longer.';
            return;
        }

        label.textContent = 'Location unavailable';
        footer.textContent = 'An unknown location error occurred.';
    }

    function requestLiveLocation() {
        setLocationSyncing(true, 'Syncing...');

        if (!navigator.geolocation) {
            setLocationSyncing(false, 'Unavailable');
            alert('Location is not supported on this device.');
            return;
        }

        navigator.geolocation.getCurrentPosition(saveLocation, handleLocationError, {
            enableHighAccuracy: true,
            timeout: 15000,
            maximumAge: 0,
        });

        if (watchId === null) {
            watchId = navigator.geolocation.watchPosition(saveLocation, handleLocationError, {
                enableHighAccuracy: true,
                timeout: 18000,
                maximumAge: 5000,
            });
        }
    }

    function centerMapOnLocation() {
        if (liveMap && locationState.latitude !== null && locationState.longitude !== null) {
            liveMap.setView([locationState.latitude, locationState.longitude], 17);
            liveMarker?.openPopup();
        } else {
            requestLiveLocation();
        }
    }

    function toggleFullscreen() {
        const el = document.querySelector('.maps-map-card');
        if (!el) return;
        if (!document.fullscreenElement) {
            el.requestFullscreen?.().then(() => setTimeout(() => liveMap?.invalidateSize(), 140)).catch(() => {});
        } else {
            document.exitFullscreen?.().then(() => setTimeout(() => liveMap?.invalidateSize(), 140)).catch(() => {});
        }
    }

    function initMap() {
        const lat = locationState.latitude ?? 20.2961;
        const lng = locationState.longitude ?? 85.8245;

        liveMap = L.map('liveMapCanvas', {
            center: [lat, lng],
            zoom: locationState.latitude !== null ? 16 : 13,
            zoomControl: false,
        });

        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            maxZoom: 19,
        }).addTo(liveMap);

        syncLocationUi();
        setTimeout(() => liveMap.invalidateSize(), 120);
    }

    document.getElementById('requestLocationButton')?.addEventListener('click', requestLiveLocation);
    document.getElementById('centerMapButton')?.addEventListener('click', centerMapOnLocation);
    document.getElementById('mapEnableLiveLocation')?.addEventListener('click', requestLiveLocation);
    document.getElementById('currentLocationFab')?.addEventListener('click', centerMapOnLocation);
    document.getElementById('fullscreenMapButton')?.addEventListener('click', toggleFullscreen);

    document.addEventListener('fullscreenchange', () => {
        document.querySelector('.maps-map-card')?.classList.toggle('is-fullscreen', Boolean(document.fullscreenElement));
        setTimeout(() => liveMap?.invalidateSize(), 140);
    });

    if (navigator.permissions?.query) {
        navigator.permissions.query({ name: 'geolocation' }).then((result) => {
            if (result.state === 'denied') {
                document.getElementById('locationLabel').textContent = 'Location permission blocked';
                document.getElementById('mapFooterMeta').textContent = 'Location is blocked for this site. Enable it in browser settings and reopen the map.';
                return;
            }

            setTimeout(() => {
                requestLiveLocation();
            }, 500);
        }).catch(() => {});
    } else if (navigator.geolocation) {
        setTimeout(() => {
            requestLiveLocation();
        }, 500);
    }

    initMap();
</script>

</x-app-layout>
