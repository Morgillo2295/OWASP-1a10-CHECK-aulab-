<x-layouts.app title="Home">
  <header class="position-relative" style="background-image: url({{asset('storage/wallpaper.jpg')}}); background-size: cover; background-position: center; min-height: 60vh;">
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0,0,0,0.55);"></div>
    <div class="container position-relative z-1 d-flex flex-column align-items-center justify-content-center" style="min-height: 60vh;">
      <h1 class="display-2 fw-bold text-white text-center mb-3" style="text-shadow: 2px 2px 8px #000;">CyberBlog</h1>
      <h2 class="lead text-white text-center mb-4" style="text-shadow: 1px 1px 6px #000;">Dive into the latest cybersecurity stories, tips and news!</h2>
      <a class="btn btn-lg px-5 py-3 fs-4 shadow d-flex align-items-center justify-content-center start-writing-btn position-relative border-0" href="{{route('articles.create')}}">
        <!-- <span class="me-3 d-flex align-items-center justify-content-center icon-glow">
          <i class="bi bi-pencil-square"></i>
        </span> -->
        <span class="fw-bold">Write something amazing</span>
      </a>
    </div>
  </header>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 text-center">
        <h2 class="mb-5 mt-4 display-6 fw-semibold">
          @if(!request()->has('search'))
            Latest Articles
          @else
            Latest Articles by: <span class="text-info">{{request()->search}}</span>
          @endif
        </h2>
      </div>
      @forelse ($articles as $article)
        <div class="col-md-4 mb-5 d-flex align-items-stretch">
          <div class="card shadow-lg border-0 w-100 h-100 article-card position-relative overflow-hidden" style="transition: transform .2s;">
            <img src="https://placehold.co/600x400/lightblue/white?text=Article%20Image" class="card-img-top" alt="..." style="object-fit: cover; height: 220px;">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title fw-bold mb-2">{{$article->title}}</h5>
              <div class="mb-2">
                <span class="badge bg-info text-dark me-2"><i class="bi bi-person"></i> {{$article->user->name}}</span>
                <span class="badge bg-secondary"><i class="bi bi-calendar-event"></i> {{$article->created_at->format('d/m/Y')}}</span>
              </div>
              <a href="{{route('articles.show',$article)}}" class="btn btn-outline-primary mt-auto fw-semibold">Read <i class="bi bi-arrow-right"></i></a>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12 text-center mt-5">
          <i class="bi bi-emoji-frown display-1 text-secondary mb-3"></i>
          <h3 class="mb-2">No articles found{{request()->has('search') ? ' with this search: '.request()->search : ''}}</h3>
          <p class="text-muted">Be the first to <a href="{{route('articles.create')}}" class="text-info fw-bold">write an article</a>!</p>
        </div>
      @endforelse
    </div>
  </div>
  <!-- Bootstrap Icons CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</x-layouts.app>