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
    .glry-lb-caption { color:#fff; text-align:center; margin-top:18px; font-size:.95rem; font-weight:600; }
    .glry-lb-caption span { display:block; color:#94a3b8; font-size:.8rem; font-weight:400; margin-top:4px; }
    .glry-lb-counter { position:fixed; top:22px; left:50%; transform:translateX(-50%); color:#94a3b8; font-size:.82rem; font-weight:600; background:rgba(255,255,255,.07); padding:4px 14px; border-radius:50px; }

    @media(max-width:1199px){.glry-grid{columns:3}}
    @media(max-width:767px){.glry-grid{columns:2}}
    @media(max-width:479px){.glry-grid{columns:1}}
</style>
{{-- HERO --}}
<section class="glry-hero py-5">
    <div class="container py-lg-4 text-center">
        <span class="badge rounded-pill bg-dark-teal mb-3 py-2 px-3 border-teal-thin">
            <i class="far fa-images text-teal me-2"></i> Photo & Video Gallery
        </span>
        <h1 class="display-5 fw-bold text-white mb-3">Our <span class="text-teal">Gallery</span></h1>
        <p class="text-light-gray mx-auto" style="max-width:580px;">
            A visual journey through world-class facilities, compassionate care, and life-changing outcomes.
        </p>
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
            <div class="col-6 col-md-3">
                <div class="glry-stat-num">4</div>
                <div class="text-light-gray" style="font-size:.82rem;">Cities</div>
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
                         data-sub="{{ $item->subtitle }}"
                         data-src="{{ asset($item->file_path) }}">
                        <img src="{{ asset($item->file_path) }}" alt="{{ $item->title }}" loading="lazy">
                        <div class="glry-overlay">
                            <div class="glry-overlay-icon"><i class="fas fa-expand-alt"></i></div>
                            <div class="glry-overlay-label">
                                {{ $item->title }}
                                <span>{{ $item->subtitle }}</span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="glry-item"
                         data-type="video"
                         data-title="{{ $item->title }}"
                         data-sub="{{ $item->subtitle }}"
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
                                <span>{{ $item->subtitle }}</span>
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
    <div class="glry-lb-caption" id="glryCaption">
        Title <span id="glrySub"></span>
    </div>
</div>

@endsection

@push('scripts')
<script>
(function () {
    const grid = document.getElementById('glryGrid');
    if (!grid) return;

    const lb      = document.getElementById('glryLightbox');
    const content = document.getElementById('glryContent');
    const caption = document.getElementById('glryCaption');
    const sub     = document.getElementById('glrySub');
    const counter = document.getElementById('glryCounter');
    let items     = Array.from(grid.querySelectorAll('.glry-item'));
    let visible   = [], currentIndex = 0, activeMedia = null;

    // Filter
    document.querySelectorAll('.glry-filter-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.glry-filter-btn').forEach(b => b.classList.remove('glry-active'));
            this.classList.add('glry-active');
            const f = this.dataset.filter;
            items.forEach(i => i.classList.toggle('glry-hidden', f !== 'all' && i.dataset.type !== f));
        });
    });

    function openLightbox(idx) {
        visible = items.filter(i => !i.classList.contains('glry-hidden'));
        currentIndex = idx;
        renderMedia(currentIndex);
        lb.classList.add('glry-open');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        lb.classList.remove('glry-open');
        document.body.style.overflow = '';
        if (activeMedia) { activeMedia.pause && activeMedia.pause(); activeMedia.src = ''; activeMedia = null; }
        content.innerHTML = '';
    }

    function renderMedia(idx) {
        if (activeMedia) { activeMedia.pause && activeMedia.pause(); activeMedia.src = ''; activeMedia = null; }
        content.innerHTML = '';
        const item = visible[idx];
        if (item.dataset.type === 'video') {
            const v = document.createElement('video');
            v.src = item.dataset.src; v.controls = true; v.autoplay = true;
            content.appendChild(v); activeMedia = v;
        } else {
            const i = document.createElement('img');
            i.src = item.dataset.src; i.alt = item.dataset.title;
            content.appendChild(i);
        }
        caption.childNodes[0].nodeValue = item.dataset.title + ' ';
        sub.textContent = item.dataset.sub;
        counter.textContent = (idx + 1) + ' / ' + visible.length;
    }

    function navigate(dir) {
        visible = items.filter(i => !i.classList.contains('glry-hidden'));
        currentIndex = (currentIndex + dir + visible.length) % visible.length;
        renderMedia(currentIndex);
    }

    items.forEach(item => {
        item.addEventListener('click', function () {
            visible = items.filter(i => !i.classList.contains('glry-hidden'));
            openLightbox(visible.indexOf(this));
        });
    });

    document.getElementById('glryClose').addEventListener('click', closeLightbox);
    document.getElementById('glryPrev').addEventListener('click', () => navigate(-1));
    document.getElementById('glryNext').addEventListener('click', () => navigate(1));
    lb.addEventListener('click', e => { if (e.target === lb) closeLightbox(); });
    document.addEventListener('keydown', e => {
        if (!lb.classList.contains('glry-open')) return;
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') navigate(-1);
        if (e.key === 'ArrowRight') navigate(1);
    });
})();
</script>
@endpush
