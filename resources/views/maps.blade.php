<x-app-layout>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css"/>

<style>
    :root {
        --maps-bottom-offset: calc(140px + env(safe-area-inset-bottom, 0px));
    }

    .maps-wrap,
    .maps-wrap *,
    .maps-map-card,
    .maps-map-card * {
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', sans-serif;
        background: var(--app-bg);
        color: var(--app-text);
        -webkit-tap-highlight-color: transparent;
    }

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
        max-width: 1280px;
        margin: 0 auto;
    }

    .maps-map-card {
        position: relative;
        min-height: calc(100dvh - 56px);
        margin-top: 22px;
        border: 1px solid rgba(148, 163, 184, 0.18);
        border-radius: 24px;
        overflow: hidden;
        background: #f8fafc;
        box-shadow: 0 24px 60px rgba(15, 23, 42, 0.08);
        isolation: isolate;
    }

    html[data-theme="dark"] .maps-map-card {
        background: color-mix(in srgb, var(--app-surface) 96%, transparent);
        border-color: var(--app-border);
        box-shadow: var(--app-shadow);
    }

    #liveMapCanvas {
        width: 100%;
        height: calc(100dvh - 56px);
        min-height: 760px;
        background: #f8fafc;
    }

    .maps-overlay {
        position: absolute;
        z-index: 650;
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(148, 163, 184, 0.18);
        box-shadow: 0 16px 38px rgba(15, 23, 42, 0.08);
        backdrop-filter: blur(18px);
    }

    html[data-theme="dark"] .maps-overlay {
        background: color-mix(in srgb, var(--app-surface) 96%, transparent);
        border-color: var(--app-border);
        box-shadow: var(--app-shadow);
    }

    .maps-topbar {
        top: 16px;
        left: 16px;
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
        width: auto;
        border-radius: 20px;
        padding: 12px 14px;
    }

    .maps-meta {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 0.68rem;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--app-text-muted);
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
        border: 1px solid rgba(148, 163, 184, 0.2);
        background: rgba(255, 255, 255, 0.96);
        color: #334155;
        font-size: 0.78rem;
        font-family: 'Inter', sans-serif;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
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

    .maps-chip.online {
        background: #ecfdf5;
        border-color: #a7f3d0;
        color: #047857;
    }

    .maps-chip.error {
        background: #fef2f2;
        border-color: #fca5a5;
        color: #dc2626;
    }

    .maps-chip-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: currentColor;
    }

    .maps-location-fab {
        position: absolute;
        right: 16px;
        bottom: 96px;
        z-index: 680;
        width: 52px;
        height: 52px;
        border-radius: 18px;
        border: 1px solid rgba(148, 163, 184, 0.18);
        background: rgba(255, 255, 255, 0.96);
        box-shadow: 0 16px 38px rgba(15, 23, 42, 0.08);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #0f172a;
        cursor: pointer;
        backdrop-filter: blur(18px);
    }

    .maps-location-fab svg {
        width: 22px;
        height: 22px;
    }

    html[data-theme="dark"] .maps-location-fab {
        background: var(--app-surface-strong);
        border-color: var(--app-border);
        color: var(--app-text);
        box-shadow: var(--app-shadow);
    }

    .maps-footer {
        left: 16px;
        width: min(560px, calc(100% - 96px));
        bottom: 16px;
        border-radius: 22px;
        padding: 14px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .maps-footer-text {
        color: var(--app-text);
        font-weight: 700;
        font-size: 0.88rem;
        line-height: 1.4;
    }

    .maps-map-card.is-fullscreen .maps-footer {
        left: 18px;
        right: 18px;
        width: auto;
        bottom: calc(22px + env(safe-area-inset-bottom, 0px));
        border-radius: 20px;
    }

    .maps-map-card.is-fullscreen .maps-location-fab {
        right: 18px;
        bottom: 96px;
    }

    .leaflet-container {
        font-family: 'Inter', sans-serif !important;
        background: #f8fafc !important;
    }

    .leaflet-pane,
    .leaflet-control-container,
    .leaflet-top,
    .leaflet-bottom {
        z-index: 1;
    }

    .leaflet-control-attribution,
    .leaflet-control-zoom {
        display: none !important;
    }

    .leaflet-popup-content-wrapper {
        background: rgba(255, 255, 255, 0.96) !important;
        border: 1px solid rgba(148, 163, 184, 0.18) !important;
        border-radius: 18px !important;
        box-shadow: 0 18px 38px rgba(15, 23, 42, 0.08) !important;
        color: var(--app-text) !important;
        font-family: 'Inter', sans-serif !important;
    }

    html[data-theme="dark"] .leaflet-popup-content-wrapper {
        background: color-mix(in srgb, var(--app-surface) 96%, transparent) !important;
        border-color: var(--app-border) !important;
        box-shadow: var(--app-shadow) !important;
    }

    .leaflet-popup-tip {
        background: rgba(255, 255, 255, 0.96) !important;
    }

    html[data-theme="dark"] .leaflet-popup-tip {
        background: color-mix(in srgb, var(--app-surface) 96%, transparent) !important;
    }

    @media (max-width: 720px) {
        :root {
            --maps-bottom-offset: calc(172px + env(safe-area-inset-bottom, 0px));
        }

        .maps-wrap {
            padding: 0;
        }

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

        .maps-topbar {
            position: fixed;
            top: calc(72px + env(safe-area-inset-top, 0px));
            z-index: 2050;
        }

        .maps-footer {
            position: fixed;
            bottom: calc(var(--maps-bottom-offset) - 28px);
            z-index: 2050;
            padding: 12px 16px;
            min-height: 62px;
        }

        .maps-footer-text {
            font-size: 0.8rem;
        }

        .maps-location-fab {
            position: fixed;
            right: 12px;
            bottom: calc(var(--maps-bottom-offset) + 34px);
            z-index: 2060;
        }

        .maps-map-card.is-fullscreen .maps-topbar {
            top: calc(10px + env(safe-area-inset-top, 0px));
            left: 10px;
            right: 10px;
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
            bottom: 104px;
        }
    }
</style>

<div class="maps-wrap">
    <div class="maps-shell">
        <section class="maps-map-card">
            <div class="maps-topbar maps-overlay">
                <div>
                    <div class="maps-map-title">Live Fleet Map</div>
                    <div class="maps-meta" id="driverCountMeta">Connecting to Traccar...</div>
                </div>
                <div class="maps-topbar-actions">
                    <button type="button" class="maps-mini-btn" id="fullscreenMapButton">Full Screen</button>
                    <div class="maps-chip" id="traccarStatusChip">
                        <span class="maps-chip-dot"></span>
                        <span id="traccarStatusText">Connecting</span>
                    </div>
                </div>
            </div>

            <div id="liveMapCanvas"></div>

            <button type="button" class="maps-location-fab" id="currentLocationFab" aria-label="Center map">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3v3m0 12v3m9-9h-3M6 12H3m9 4a4 4 0 100-8 4 4 0 000 8z"/>
                </svg>
            </button>

            <div class="maps-footer maps-overlay">
                <div>
                    <div class="maps-meta">Fleet Status</div>
                    <div class="maps-footer-text" id="mapFooterMeta">Loading driver positions...</div>
                </div>
            </div>
        </section>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
<script>
    const POLL_INTERVAL_MS = {{ config('traccar.poll_interval', 10) * 1000 }};
    const POSITIONS_URL = '{{ route('fleet.positions') }}';
    const DEFAULT_CENTER = [20.2961, 85.8245];
    const DEFAULT_ZOOM = 13;

    let liveMap = null;
    let pollTimer = null;
    let markers = {};
    let firstLoad = true;

    function initMap() {
        liveMap = L.map('liveMapCanvas', {
            center: DEFAULT_CENTER,
            zoom: DEFAULT_ZOOM,
            zoomControl: false,
        });

        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            maxZoom: 19,
        }).addTo(liveMap);

        setTimeout(() => liveMap.invalidateSize(), 120);
    }

    function buildIcon(isOnline) {
        const outerColor = isOnline ? '#16a34a' : '#64748b';

        return L.divIcon({
            className: '',
            html: `
                <div style="
                    width:40px;
                    height:40px;
                    border-radius:50%;
                    background:${outerColor};
                    border:4px solid rgba(255,255,255,0.95);
                    box-shadow:0 12px 28px rgba(15,23,42,0.18);
                    display:flex;
                    align-items:center;
                    justify-content:center;">
                    <span style="
                        width:10px;
                        height:10px;
                        border-radius:50%;
                        background:#ffffff;
                        display:block;"></span>
                </div>
            `,
            iconSize: [40, 40],
            iconAnchor: [20, 20],
            popupAnchor: [0, -24],
        });
    }

    function popupHtml(driver) {
        const statusText = driver.status === 'online' ? 'Online' : 'Offline';
        const speedText = driver.speed !== null ? `${driver.speed} km/h` : 'Speed unknown';
        const accuracyText = driver.accuracy !== null ? `${Math.round(driver.accuracy)} m` : 'Unknown';
        const updatedText = driver.updated_at
            ? new Date(driver.updated_at).toLocaleTimeString()
            : 'Unknown';

        return `
            <div style="min-width:160px;">
                <div style="font-weight:700;font-size:0.94rem;margin-bottom:4px;">${driver.name}</div>
                <div style="font-size:0.8rem;color:#64748b;margin-bottom:6px;">${statusText}</div>
                <div style="font-family:'IBM Plex Mono',monospace;font-size:0.7rem;color:#94a3b8;line-height:1.6;">
                    ${driver.latitude.toFixed(6)}, ${driver.longitude.toFixed(6)}<br>
                    Speed: ${speedText}<br>
                    Accuracy: ${accuracyText}<br>
                    Updated: ${updatedText}
                </div>
            </div>
        `;
    }

    function updateMarkers(drivers) {
        const seenIds = new Set();

        drivers.forEach((driver) => {
            if (driver.latitude === null || driver.longitude === null) {
                return;
            }

            const id = driver.device_id;
            const isOnline = driver.status === 'online';
            const latlng = [driver.latitude, driver.longitude];

            seenIds.add(id);

            if (markers[id]) {
                markers[id].setLatLng(latlng);
                markers[id].setIcon(buildIcon(isOnline));
                markers[id].getPopup()?.setContent(popupHtml(driver));
                return;
            }

            markers[id] = L.marker(latlng, { icon: buildIcon(isOnline) })
                .bindPopup(popupHtml(driver))
                .addTo(liveMap);
        });

        Object.keys(markers).forEach((id) => {
            if (!seenIds.has(Number(id))) {
                liveMap.removeLayer(markers[id]);
                delete markers[id];
            }
        });

        if (firstLoad && seenIds.size > 0) {
            firstLoad = false;
            const group = L.featureGroup(Object.values(markers));
            liveMap.fitBounds(group.getBounds().pad(0.2));
        }
    }

    function setStatus(state, text) {
        const chip = document.getElementById('traccarStatusChip');
        const label = document.getElementById('traccarStatusText');

        chip.className = 'maps-chip';

        if (state === 'online') {
            chip.classList.add('online');
        } else if (state === 'error') {
            chip.classList.add('error');
        }

        label.textContent = text;
    }

    function setFooter(text) {
        document.getElementById('mapFooterMeta').textContent = text;
    }

    function setDriverCount(count) {
        document.getElementById('driverCountMeta').textContent =
            count === 0 ? 'No drivers online' : `${count} driver${count !== 1 ? 's' : ''} tracked`;
    }

    async function pollPositions() {
        try {
            const response = await fetch(POSITIONS_URL, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'ngrok-skip-browser-warning': 'true',
                },
            });

            if (!response.ok) {
                // Show the actual HTTP error, not a generic Traccar message
                const errorText = await response.text();
                console.warn('[Fleet] HTTP error:', response.status, errorText);

                if (response.status === 401 || response.status === 419) {
                    setStatus('error', 'Session Expired');
                    setFooter('Your session expired. Please refresh the page to log in again.');
                } else {
                    setStatus('error', `Error ${response.status}`);
                    setFooter(`Server error ${response.status}. Check Laravel logs.`);
                }
                return;
            }

            const data = await response.json();
            const drivers = data.drivers ?? [];
            const onlineDrivers = drivers.filter((driver) => driver.status === 'online' && driver.latitude !== null);

            updateMarkers(drivers);
            setStatus('online', 'Traccar Live');
            setDriverCount(onlineDrivers.length);

            if (onlineDrivers.length === 0) {
                setFooter('No drivers currently online. Waiting for Traccar updates...');
                return;
            }

            setFooter(
                `${onlineDrivers.length} active driver${onlineDrivers.length !== 1 ? 's' : ''} - positions update every ${POLL_INTERVAL_MS / 1000}s`
            );
        } catch (error) {
            console.warn('[Fleet] Poll error:', error);
            setStatus('error', 'Network Error');
            setFooter(`Connection failed: ${error.message}`);
        }
    }

    function centerMap() {
        const allMarkers = Object.values(markers);

        if (allMarkers.length === 0) {
            liveMap.setView(DEFAULT_CENTER, DEFAULT_ZOOM);
            return;
        }

        if (allMarkers.length === 1) {
            liveMap.setView(allMarkers[0].getLatLng(), 16);
            return;
        }

        const group = L.featureGroup(allMarkers);
        liveMap.fitBounds(group.getBounds().pad(0.2));
    }

    function toggleFullscreen() {
        const card = document.querySelector('.maps-map-card');

        if (!card) {
            return;
        }

        if (!document.fullscreenElement) {
            card.requestFullscreen?.()
                .then(() => setTimeout(() => liveMap?.invalidateSize(), 140))
                .catch(() => {});
            return;
        }

        document.exitFullscreen?.()
            .then(() => setTimeout(() => liveMap?.invalidateSize(), 140))
            .catch(() => {});
    }

    document.getElementById('fullscreenMapButton')?.addEventListener('click', toggleFullscreen);
    document.getElementById('currentLocationFab')?.addEventListener('click', centerMap);

    document.addEventListener('fullscreenchange', () => {
        document.querySelector('.maps-map-card')?.classList.toggle('is-fullscreen', Boolean(document.fullscreenElement));
        setTimeout(() => liveMap?.invalidateSize(), 140);
    });

    initMap();
    pollPositions();
    pollTimer = setInterval(pollPositions, POLL_INTERVAL_MS);
</script>

</x-app-layout>
