<x-layouts.app>
    <div class="container">
        <div class="row">
            @forelse ($articles as $article)
            <div class="card col-md-4 mb-3" >
                <img src="https://picsum.photos/300?a={{$loop->index}}" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">{{$article->title}}</h5>
                  <p class="card-text">{!!$article->content!!}</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
              </div>
            @empty
                
            @endforelse
        </div>
    </div>
    
    </x-layouts.app>