<?php

namespace App\ShortUrl\Controllers;

use App\Http\Controllers\Controller;
use App\LinkAnalytic\Handlers\LinkAnalyticHandler;
use App\LinkAnalytic\Models\LinkAnalytic;
use App\ShortUrl\Events\E_ShortUrlRedirected;
use App\ShortUrl\Handlers\ShortUrlHandler;
use App\ShortUrl\Models\ShortUrl;
use App\ShortUrl\Requests\CreateShortUrlRequest;
use App\ShortUrl\Requests\GetAnalyticsByShortUrlIdRequest;
use App\ShortUrl\Requests\UpdateShortUrlRequest;
use App\ShortUrl\Transformers\ShortUrlTransformer;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

class ShortUrlController extends Controller
{
    public function create(CreateShortUrlRequest $request): JsonResponse
    {
        $user = Auth::user();
        $shortUrl = ShortUrlHandler::create($user, $request->all());

        $resource = new Item($shortUrl, new ShortUrlTransformer(), 'short_url');

        return $this->response($shortUrl, $resource, Response::HTTP_CREATED, false);
    }

    public function listByUser(): JsonResponse
    {
        $user = Auth::user();
        $shortUrls = ShortUrlHandler::listByUser($user);

        $resource = new Collection($shortUrls, new ShortUrlTransformer(), 'short_urls');

        return $this->response($shortUrls, $resource, Response::HTTP_CREATED, false);
    }

    public function update(UpdateShortUrlRequest $request): JsonResponse
    {
        $id = $request->offsetGet('short_url_id');
        $params = $request->except(['short_url_id']);

        if (ShortUrlHandler::update($id, $params) > 0) {
            return $this->returnSuccess();
        }

        return $this->returnFail();
    }

    public function redirect(string $slug): View|RedirectResponse
    {
        $shortUrl = ShortUrlHandler::getBySlug($slug);

        if ($shortUrl->expiration_time <= Carbon::now()) {
            return view('expired_link');
        }

        if ($shortUrl->exit_page) {
            $quote = ShortUrlHandler::getExitPageQuote();
            event(new E_ShortUrlRedirected($shortUrl, LinkAnalytic::TYPE_EXIT_PAGE_REDIRECTION));
            return view('exit_page', ['quote' => $quote, 'shortUrl' => $shortUrl]);
        }

        event(new E_ShortUrlRedirected($shortUrl, LinkAnalytic::TYPE_DAILY_REDIRECTION));
        return redirect($shortUrl->link);
    }

    public function getAnalytics(GetAnalyticsByShortUrlIdRequest $request): JsonResponse
    {
        $shortUrlId = $request->offsetGet('short_url_id');
        $shortUrl = ShortUrlHandler::getById($shortUrlId);
        $analytics = LinkAnalyticHandler::getAnalyticsByShortUrl($shortUrl);

        return response()->json($analytics);
    }
}
