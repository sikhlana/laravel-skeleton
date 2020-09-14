<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\View\View;
use Illuminate\Support\Arr;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class JsonifyResponse
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * @throws \Throwable
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($request->expectsJson() && ! $response instanceof JsonResponse) {
            $data = null;
            $statusCode = 200;

            if ($response instanceof RedirectResponse) {
                $data = [
                    'redirect' => $response->getTargetUrl(),
                ];
            } else if ($response instanceof Response) {
                $content = $response->getOriginalContent();
                $statusCode = $response->status();

                if ($content instanceof View) {
                    $sections = $content->renderSections();

                    $data = [
                        'title' => $sections['page-header'] ?? ($sections['page-title'] ?? null),
                        'class' => str_replace('.', ' ', $content->getName()),
                        'size' => $sections['modal-size'] ?? null,
                        'contents' => $sections['contents'] ?? null,
                        'extra' => json_decode($sections['extra-json'] ?? '{}'),
                        'hide_modal_header' => ! empty($sections['hide-modal-header']),
                    ];
                }
            }

            $headers = Arr::except($response->headers->all(), [
                'content-type', 'content-length', 'cache-control',
                'date', 'location',
            ]);

            $response = response()->json(
                $data, $statusCode, $headers
            );
        }

        return $response;
    }
}
