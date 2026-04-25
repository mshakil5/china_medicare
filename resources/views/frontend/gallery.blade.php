@extends('frontend.layouts.master')

@section('title', 'Gallery - China Medicare')

@section('styles')

@endsection

@section('content')
<style>
    :root { --glry-teal: #D8202A; --glry-navy: #0f172a; --glry-radius: 16px; --glry-t: 0.32s cubic-bezier(.4,0,.2,1); }

    .glry-hero { background: linear-gradient(rgba(15,23,42,0.92),rgba(15,23,42,0.92)), url('https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=1600') center/cover; }
    .glry-stats-strip { background: var(--glry-navy); }
    .glry-stat-num { font-size:1.8rem; font-weight:700; color:var(--glry-teal); }

    .glry-filter-wrap { display:flex; gap:10px; flex-wrap:wrap; justify-content:center; }
    .glry-filter-btn { border:1.5px solid #dee2e6; background:#fff; color:#4b5563; border-radius:50px; padding:8px 24px; font-size:.875rem; font-weight:600; cursor:pointer; transition:var(--glry-t); outline:none; }
    .glry-filter-btn:hover { border-color:var(--glry-teal); color:var(--glry-teal); }
    .glry-filter-btn.glry-active { background:var(--glry-teal); border-color:var(--glry-teal); color:#fff; }

    .glry-grid { columns:4; column-gap:16px; }
    .glry-item { break-inside:avoid; margin-bottom:16px; position:relative; border-radius:var(--glry-radius); overflow:hidden; cursor:pointer; display:block; }
    .glry-item img { width:100%; display:block; border-radius:var(--glry-radius); transition:transform var(--glry-t); }
    .glry-item:hover img { transform:scale(1.04); }

    .glry-overlay { position:absolute; inset:0; background:linear-gradient(to top,rgba(15,23,42,.85) 0%,rgba(15,23,42,.1) 60%,transparent); opacity:0; transition:opacity var(--glry-t); border-radius:var(--glry-radius); display:flex; align-items:flex-end; padding:18px; }
    .glry-item:hover .glry-overlay { opacity:1; }
    .glry-overlay-icon { width:44px; height:44px; border-radius:50%; background:var(--glry-teal); display:flex; align-items:center; justify-content:center; color:#fff; font-size:1rem; margin-right:12px; flex-shrink:0; }
    .glry-overlay-label { color:#fff; font-size:.82rem; font-weight:600; line-height:1.3; }
    .glry-overlay-label span { display:block; color:#94a3b8; font-weight:400; font-size:.75rem; }

    .glry-video-badge { position:absolute; top:12px; left:12px; background:var(--glry-teal); color:#fff; font-size:.7rem; font-weight:700; padding:3px 10px; border-radius:50px; letter-spacing:.05em; text-transform:uppercase; z-index:2; display:flex; align-items:center; gap:5px; }
    .glry-play-btn { position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); width:52px; height:52px; background:rgba(255,255,255,.92); border-radius:50%; display:flex; align-items:center; justify-content:center; color:var(--glry-teal); font-size:1.1rem; z-index:2; box-shadow:0 4px 20px rgba(0,0,0,.25); transition:transform var(--glry-t); }
    .glry-item:hover .glry-play-btn { transform:translate(-50%,-50%) scale(1.1); }
    .glry-item.glry-hidden { display:none; }

    /* Lightbox */
    .glry-lightbox { display:none; position:fixed; inset:0; background:rgba(7,10,22,.97); z-index:9999; align-items:center; justify-content:center; flex-direction:column; padding:20px; }
    .glry-lightbox.glry-open { display:flex; animation:glryFadeIn .25s ease; }
    @keyframes glryFadeIn { from{opacity:0} to{opacity:1} }
    .glry-lb-close { position:fixed; top:20px; right:24px; width:44px; height:44px; background:rgba(255,255,255,.1); border:1.5px solid rgba(255,255,255,.2); border-radius:50%; color:#fff; font-size:1.1rem; display:flex; align-items:center; justify-content:center; cursor:pointer; z-index:10001; transition:background .2s; }
    .glry-lb-close:hover { background:var(--glry-teal); border-color:var(--glry-teal); }
    .glry-lb-content { max-width:1100px; width:100%; max-height:85vh; display:flex; align-items:center; justify-content:center; }
    .glry-lb-content img { max-width:100%; max-height:80vh; border-radius:12px; object-fit:contain; box-shadow:0 30px 80px rgba(0,0,0,.6); }
    .glry-lb-content video { max-width:100%; max-height:80vh; border-radius:12px; box-shadow:0 30px 80px rgba(0,0,0,.6); }
    .glry-lb-nav { position:fixed; top:50%; transform:translateY(-50%); width:48px; height:48px; background:rgba(255,255,255,.1); border:1.5px solid rgba(255,255,255,.2); border-radius:50%; color:#fff; font-size:1rem; display:flex; align-items:center; justify-content:center; cursor:pointer; z-index:10001; transition:background .2s; }
    .glry-lb-nav:hover { background:var(--glry-teal); border-color:var(--glry-teal); }
    .glry-lb-prev { left:16px; } .glry-lb-next { right:16px; }
    .glry-lb-caption { color:#fff; text-align:center; margin-top:18px; font-size:.95rem; font-weight:600; min-height:2.5em; }
    .glry-lb-caption span { display:block; color:#94a3b8; font-size:.8rem; font-weight:400; margin-top:4px; }
    .glry-lb-counter { position:fixed; top:22px; left:50%; transform:translateX(-50%); color:#94a3b8; font-size:.82rem; font-weight:600; background:rgba(255,255,255,.07); padding:4px 14px; border-radius:50px; }

    @media(max-width:1199px){.glry-grid{columns:3}}
    @media(max-width:767px){.glry-grid{columns:2}}
    @media(max-width:479px){.glry-grid{columns:1}}
</style>
{{-- HERO --}}
<section class="glry-hero py-5">
    <div class="container py-lg-4 text-center">
        <h1 class="display-5 fw-bold text-white mb-3">Our <span class="text-teal">Gallery</span></h1>
    </div>
</section>

{{-- STATS STRIP --}}
<div class="glry-stats-strip py-4">
    <div class="container">
        <div class="row text-center g-3">
            <div class="col-6 col-md-3">
                <div class="glry-stat-num">{{ $items->where('type','image')->count() }}</div>
                <div class="text-light-gray" style="font-size:.82rem;">Photos</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="glry-stat-num">{{ $items->where('type','video')->count() }}</div>
                <div class="text-light-gray" style="font-size:.82rem;">Videos</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="glry-stat-num">{{ $items->count() }}</div>
                <div class="text-light-gray" style="font-size:.82rem;">Total Media</div>
            </div>
        </div>
    </div>
</div>

{{-- GALLERY --}}
<section class="py-5 bg-light">
    <div class="container py-lg-3">

        {{-- Filter Tabs --}}
        <div class="glry-filter-wrap mb-5">
            <button class="glry-filter-btn glry-active" data-filter="all">
                <i class="fas fa-th me-2"></i>All ({{ $items->count() }})
            </button>
            <button class="glry-filter-btn" data-filter="image">
                <i class="fas fa-image me-2"></i>Photos ({{ $items->where('type','image')->count() }})
            </button>
            <button class="glry-filter-btn" data-filter="video">
                <i class="fas fa-video me-2"></i>Videos ({{ $items->where('type','video')->count() }})
            </button>
        </div>

        @if($items->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="fas fa-images fa-3x mb-3 d-block opacity-25"></i>
                No gallery items found.
            </div>
        @else
        {{-- Masonry Grid --}}
        <div class="glry-grid" id="glryGrid">
            @foreach($items as $item)
                @if($item->type === 'image')
                    <div class="glry-item"
                         data-type="image"
                         data-title="{{ $item->title }}"
                         data-sub="{{ $item->subtitle ?? '' }}"
                         data-src="{{ asset($item->file_path) }}">
                        <img src="{{ asset($item->file_path) }}" alt="{{ $item->title }}" loading="lazy">
                        <div class="glry-overlay">
                            <div class="glry-overlay-icon"><i class="fas fa-expand-alt"></i></div>
                            <div class="glry-overlay-label">
                                {{ $item->title }}
                                <span>{{ $item->subtitle ?? '' }}</span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="glry-item"
                         data-type="video"
                         data-title="{{ $item->title }}"
                         data-sub="{{ $item->subtitle ?? '' }}"
                         data-src="{{ asset($item->file_path) }}"
                         data-poster="{{ $item->thumbnail ? asset($item->thumbnail) : '' }}">
                        <div class="glry-video-badge">
                            <i class="fas fa-play" style="font-size:.55rem;"></i> Video
                        </div>
                        <img src="{{ $item->thumbnail ? asset($item->thumbnail) : asset($item->file_path) }}"
                             alt="{{ $item->title }}" loading="lazy">
                        <div class="glry-play-btn">
                            <i class="fas fa-play" style="margin-left:3px;"></i>
                        </div>
                        <div class="glry-overlay">
                            <div class="glry-overlay-icon"><i class="fas fa-play"></i></div>
                            <div class="glry-overlay-label">
                                {{ $item->title }}
                                <span>{{ $item->subtitle ?? '' }}</span>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        @endif

    </div>
</section>

{{-- LIGHTBOX --}}
<div class="glry-lightbox" id="glryLightbox" role="dialog" aria-modal="true">
    <button class="glry-lb-close" id="glryClose"><i class="fas fa-times"></i></button>
    <div class="glry-lb-counter" id="glryCounter"></div>
    <button class="glry-lb-nav glry-lb-prev" id="glryPrev"><i class="fas fa-chevron-left"></i></button>
    <button class="glry-lb-nav glry-lb-next" id="glryNext"><i class="fas fa-chevron-right"></i></button>
    <div class="glry-lb-content" id="glryContent"></div>
    <div class="glry-lb-caption" id="glryCaption"></div>
</div>

@endsection

@section('script')
<script>
(function () {
    var grid = document.getElementById('glryGrid');
    if (!grid) return;

    var lb      = document.getElementById('glryLightbox');
    var content = document.getElementById('glryContent');
    var caption = document.getElementById('glryCaption');
    var counter = document.getElementById('glryCounter');
    var items   = Array.from(grid.querySelectorAll('.glry-item'));
    var visible = [];
    var currentIndex = 0;
    var activeMedia  = null;

    // Filter buttons
    document.querySelectorAll('.glry-filter-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.glry-filter-btn').forEach(function (b) {
                b.classList.remove('glry-active');
            });
            this.classList.add('glry-active');
            var f = this.dataset.filter;
            items.forEach(function (i) {
                i.classList.toggle('glry-hidden', f !== 'all' && i.dataset.type !== f);
            });
        });
    });

    function getVisible() {
        return items.filter(function (i) { return !i.classList.contains('glry-hidden'); });
    }

    function openLightbox(idx) {
        visible = getVisible();
        if (idx < 0 || idx >= visible.length) return;
        currentIndex = idx;

        // OPEN LIGHTBOX FIRST — before renderMedia, so it's always visible
        lb.classList.add('glry-open');
        document.body.style.overflow = 'hidden';

        renderMedia(currentIndex);
    }

    function closeLightbox() {
        lb.classList.remove('glry-open');
        document.body.style.overflow = '';
        if (activeMedia) {
            if (typeof activeMedia.pause === 'function') activeMedia.pause();
            activeMedia.src = '';
            activeMedia = null;
        }
        content.innerHTML = '';
        caption.innerHTML = '';
        counter.textContent = '';
    }

    function renderMedia(idx) {
        // Cleanup previous
        if (activeMedia) {
            if (typeof activeMedia.pause === 'function') activeMedia.pause();
            activeMedia.src = '';
            activeMedia = null;
        }
        content.innerHTML = '';
        caption.innerHTML = '';

        var item = visible[idx];
        if (!item) return;

        var type  = item.dataset.type || 'image';
        var src   = item.dataset.src || '';
        var title = item.dataset.title || '';
        var sub   = item.dataset.sub || '';

        if (type === 'video') {
            var v = document.createElement('video');
            v.src = src;
            v.controls = true;
            v.autoplay = true;
            if (item.dataset.poster) v.poster = item.dataset.poster;
            content.appendChild(v);
            activeMedia = v;
        } else {
            var img = document.createElement('img');
            img.src = src;
            img.alt = title;
            content.appendChild(img);
        }

        // Build caption safely — no childNodes[0] dependency
        var titleNode = document.createTextNode(title);
        caption.appendChild(titleNode);
        if (sub) {
            var subSpan = document.createElement('span');
            subSpan.textContent = sub;
            caption.appendChild(subSpan);
        }

        counter.textContent = (idx + 1) + ' / ' + visible.length;
    }

    function navigate(dir) {
        visible = getVisible();
        if (visible.length === 0) return;
        currentIndex = (currentIndex + dir + visible.length) % visible.length;
        renderMedia(currentIndex);
    }

    // Attach click to each gallery item
    items.forEach(function (item) {
        item.addEventListener('click', function () {
            visible = getVisible();
            var idx = visible.indexOf(this);
            openLightbox(idx);
        });
    });

    // Controls
    document.getElementById('glryClose').addEventListener('click', closeLightbox);
    document.getElementById('glryPrev').addEventListener('click', function () { navigate(-1); });
    document.getElementById('glryNext').addEventListener('click', function () { navigate(1); });

    lb.addEventListener('click', function (e) {
        if (e.target === lb) closeLightbox();
    });

    document.addEventListener('keydown', function (e) {
        if (!lb.classList.contains('glry-open')) return;
        if (e.key === 'Escape')     closeLightbox();
        if (e.key === 'ArrowLeft')  navigate(-1);
        if (e.key === 'ArrowRight') navigate(1);
    });
})();
</script>
@endsection