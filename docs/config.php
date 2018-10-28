<?php

use Sami\Sami;
use Sami\RemoteRepository\GitHubRemoteRepository;
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->in(__DIR__.'/../app')
;

return new Sami($iterator, array(
    'title'                => 'Jano Ticketing System',
    'build_dir'            => __DIR__.'/_api',
    'cache_dir'            => __DIR__.'/_cache',
    'remote_repository'    => new GitHubRemoteRepository('jano-may-ball/ticketing', dirname(__DIR__.'/../app')),
    'default_opened_level' => 2,
));