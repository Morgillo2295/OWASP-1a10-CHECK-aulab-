<?php 

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\HtmlFilterService;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index(Request $request, HtmlFilterService $htmlFilterService)
    {
        $articles = Article::latest()->where('published', true)->take(6)->get();
        $articles = $htmlFilterService->filterHtmlCollectionByField($articles, 'content');

        if ($request->wantsJson()) {
            return response()->json($articles);
        }
        
        return view('articles.index', compact('articles'));
    }

    public function search(Request $request, HtmlFilterService $htmlFilterService)
    {
        
        // // UNSECURE
        // $articles = Article::whereRaw("title like '%{$request->search}%'")->get();

        //SECURE
        $validated = $request->validate([
            'search' => 'nullable|string|max:255',
        ]);

        $query = Article::query();

        if (! empty($validated['search'])) {
            $query->where('title', 'LIKE', "%{$validated['search']}%")
                  ->orWhere('content', 'LIKE', "%{$validated['search']}%");
        }

        $articles = $query->get();
        $articles = $htmlFilterService->filterHtmlCollectionByField($articles, 'content');

        return view('articles.index', compact('articles'));
    }
    
    public function show(Article $article, Request $request, HtmlFilterService $htmlFilterService)
    {
        $article->content = $htmlFilterService->filterHtml((string) $article->content);

        if ($request->wantsJson()) {
            return response()->json($article);
        }
        
        return view('articles.show', compact('article'));
    }
    
    public function create()
    {
        return view('articles.create');
    }
    
    public function store(Request $request, HtmlFilterService $htmlFilterService)
    {
        $articleData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published' => 'sometimes|boolean',
        ]);

        $articleData['content'] = $htmlFilterService->filterHtml($articleData['content']);
        $articleData['user_id'] = Auth::id();

        $article = Article::create($articleData);
        
        if ($request->wantsJson()) {
            return response()->json($article, 201);
        }
        
        return redirect()->route('articles.index');
    }

    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article, HtmlFilterService $htmlFilterService)
    {
        $articleData = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'published' => 'sometimes|boolean',
        ]);

        if (array_key_exists('content', $articleData)) {
            $articleData['content'] = $htmlFilterService->filterHtml($articleData['content']);
        }

        $article->update($articleData);
        
        if ($request->wantsJson()) {
            return response()->json($article, 200);
        }
        
        return redirect()->route('articles.show', $article);
    }
    
    public function destroy(Article $article, Request $request)
    {
        // SECURE
        if(Auth::id() !== $article->user_id){
            return redirect()->route('articles.show', $article)->with('message','Not authorized');
        }
        
        $article->delete();
        
        if ($request->wantsJson()) {
            return response()->json(null, 204);
        }
        
        return redirect()->route('articles.index')->with('message','Article deleted successfully');
    }
}
