<?php

return [
	'host' => env('STATSD_HOST', '127.0.0.1'),

	'port' => env('STATSD_PORT', 8125),

	'namespace' => env('STATSD_NAMESPACE', \Illuminate\Support\Str::slug(env('APP_NAME', 'laravel'))),

	'throwConnectionExceptions' => false
];
