<?php

namespace Lareon\CMS\App\Logic;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Teksite\Authorize\Models\Role;
use Teksite\Handler\Actions\ServiceResult;
use Teksite\Handler\Actions\ServiceWrapper;
use Teksite\Handler\Services\FetchDataService;

class CacheLogic
{
//    /**
//     * @return ServiceResult
//     */
//    public function get(): ServiceResult
//    {
//        return app(ServiceWrapper::class)(function () {
//            return $this->list();
//        });
//    }
//
//    /**
//     * @param string $input
//     * @return ServiceResult
//     */
//    public function runCommand(string $input): ServiceResult
//    {
//        return app(ServiceWrapper::class)(function () use ($input) {
//            $explodeCommand = explode('.', $input);
//            $commandData = $this->list()[$explodeCommand[0]][$explodeCommand[1]] ?? null;
//            if ($commandData) {
//                $typeCommand = $commandData['command-type'] ?? null;
//                $command = $commandData['command'] ?? null;
//                if (is_null($typeCommand) || is_null($command))throw new \Exception("Command not found");
//
//                if ($typeCommand == 'artisan') {
//                    Artisan::call($command);
//                }
//                if ($typeCommand === 'class') {
//                    if (class_exists($command[0]) && method_exists($command[0], $command[1])) {
//                        forward_static_call($command);
//                    } else {
//                        throw new \Exception("Invalid class or method.");
//                    }
//                }
//            } else {
//                throw new \Exception("Command not found");
//            }
//        });
//    }
//
//    /**
//     * @return array[]
//     */
//    private function list(): array
//    {
//        $items = [
//            'auth' => [
//                'clear-resets' => [
//                    "type" => "clear",
//                    "desc" => "Flush expired password reset tokens",
//                    "command" => "auth:clear-resets",
//                    "command-type" => "artisan"
//                ],
//            ],
//            'optimize' => [
//                'optimize' => [
//                    "type" => "store",
//                    "desc" => "Cache framework bootstrap, configuration, and metadata to increase performance",
//                    "command" => "optimize",
//                    "command-type" => "artisan"
//                ],
//                'clear' => [
//                    "type" => "clear",
//                    "desc" => "Remove the cached bootstrap files",
//                    "command" => "optimize:clear",
//                    "command-type" => "artisan"
//                ]
//            ],
//            'cache' => [
//                'clear' => [
//                    "type" => "clear",
//                    "desc" => "Flush the application cache",
//                    "command" => "cache:clear",
//                    "command-type" => "artisan"
//                ],
//                'forget' => [
//                    "type" => "clear",
//                    "desc" => "Remove the configuration cache file",
//                    "command" => "cache:forget",
//                    "command-type" => "artisan"
//                ],
//                'prune-stale-tags' => [
//                    "type" => "clear",
//                    "desc" => "Prune stale cache tags from the cache (Redis only)",
//                    "command" => "cache:prune-stale-tags",
//                    "command-type" => "artisan"
//                ],
//            ],
//            'config' => [
//                'cache' => [
//                    "type" => "store",
//                    "desc" => "Create a cache file for faster configuration loading",
//                    "command" => "config:cache",
//                    "command-type" => "artisan"
//                ],
//                'clear' => [
//                    "type" => "clear",
//                    "desc" => "Remove the configuration cache file",
//                    "command" => "config:clear",
//                    "command-type" => "artisan"
//                ],
//            ],
//            'event' => [
//                'cache' => [
//                    "type" => "store",
//                    "desc" => "Discover and cache the application's events and listeners",
//                    "command" => "event:cache",
//                    "command-type" => "artisan"
//                ],
//                'clear' => [
//                    "type" => "clear",
//                    "desc" => "Clear all cached events and listeners",
//                    "command" => "event:clear",
//                    "command-type" => "artisan"
//                ],
//            ],
//            'route' => [
//                'cache' => [
//                    "type" => "store",
//                    "desc" => "Create a route cache file for faster route registration",
//                    "command" => "route:cache",
//                    "command-type" => "artisan"
//                ],
//                'clear' => [
//                    "type" => "clear",
//                    "desc" => "Remove the route cache file",
//                    "command" => "route:clear",
//                    "command-type" => "artisan"
//
//                ],
//            ],
//            'view' => [
//                'cache' => [
//                    "type" => "store",
//                    "desc" => "Compile all of the application's Blade templates",
//                    "command" => "route:cache",
//                    "command-type" => "artisan"
//                ],
//                'clear' => [
//                    "type" => "clear",
//                    "desc" => "Clear all compiled view files",
//                    "command" => "route:clear",
//                    "command-type" => "artisan"
//                ],
//            ],
//            'schedule' => [
//                'clear-cache' => [
//                    "type" => 'store',
//                    "desc" => 'Delete the cached mutex files created by scheduler',
//                    "command" => 'schedule:clear-cache',
//                    "command-type" => "artisan"
//                ],
//            ],
//        ];
//        if (class_exists(\Spatie\ResponseCache\Facades\ResponseCache::class)) {
//            $items[] = [
//                'response' => [
//                    'clear' => [
//                        "type" => "clear",
//                        "desc" => "Clear response caches",
//                        "command" => [\Spatie\ResponseCache\Facades\ResponseCache::class, 'clear'],
//                        "command-type" => 'class',
//                    ]
//                ]
//            ];
//        }
//        return $items;
//    }
//
//    //


    private const COMMAND_TYPES = [
        'artisan' => 'executeArtisanCommand',
        'class' => 'executeClassCommand',
    ];

    private const CACHE_COMMANDS = [

        'optimize' => [
            'optimize' => ['store', 'Cache framework bootstrap, configuration, and metadata', 'optimize', 'artisan'],
            'clear' => ['clear', 'Remove cached bootstrap files', 'optimize:clear', 'artisan'],
        ],
        'cache' => [
            'clear' => ['clear', 'Flush application cache', 'cache:clear', 'artisan'],
            'prune-stale-tags' => ['clear', 'Prune stale cache tags (Redis only)', 'cache:prune-stale-tags', 'artisan'],
        ],
        'config' => [
            'cache' => ['store', 'Create configuration cache file', 'config:cache', 'artisan'],
            'clear' => ['clear', 'Remove configuration cache file', 'config:clear', 'artisan'],
        ],
        'event' => [
            'cache' => ['store', 'Cache events and listeners', 'event:cache', 'artisan'],
            'clear' => ['clear', 'Clear cached events and listeners', 'event:clear', 'artisan'],
        ],
        'route' => [
            'cache' => ['store', 'Create route cache file', 'route:cache', 'artisan'],
            'clear' => ['clear', 'Remove route cache file', 'route:clear', 'artisan'],
        ],
        'view' => [
            'cache' => ['store', 'Compile Blade templates', 'view:cache', 'artisan'],
            'clear' => ['clear', 'Clear compiled view files', 'view:clear', 'artisan'],
        ],
        'schedule' => [
            'clear-cache' => ['clear', 'Delete scheduler cached mutex files', 'schedule:clear-cache', 'artisan'],
        ],
        'auth' => [
            'clear-resets' => ['clear', 'Flush expired password reset tokens', 'auth:clear-resets', 'artisan'],
        ],
    ];

    public function get(): ServiceResult
    {
        return app(ServiceWrapper::class)(fn() => $this->formatCommands());
    }

    public function runCommand(string $input): ServiceResult
    {
        return app(ServiceWrapper::class)(function () use ($input) {
            [$group, $command] = explode('.', $input, 2);
            $commandData = $this->getCommandData($group, $command);
            $this->validateCommand($commandData);
            $handler = self::COMMAND_TYPES[$commandData[3]];

           return $this->$handler($commandData[2]);
        });
    }

    private function getCommandData(string $group, string $command): ?array
    {
        return self::CACHE_COMMANDS[$group][$command] ?? null;
    }

    private function validateCommand(?array $commandData): void
    {
        if (!$commandData) {
            throw new \Exception("Command not found");
        }
    }

    private function executeArtisanCommand(string $command): void
    {
        Artisan::call($command);
    }

    private function executeClassCommand(array $command): void
    {
        [$class, $method] = $command;
        if (!class_exists($class) || !method_exists($class, $method)) {
            throw new \Exception("Invalid class or method");
        }
        forward_static_call($command);
    }

    private function formatCommands(): array
    {
        $commands = self::CACHE_COMMANDS;

        if (class_exists(\Spatie\ResponseCache\Facades\ResponseCache::class)) {
            $commands['response'] = [
                'clear' => [
                    'clear',
                    'Clear response caches',
                    [\Spatie\ResponseCache\Facades\ResponseCache::class, 'clear'],
                    'class'
                ]
            ];
        }

        return array_map(fn($group) => array_map(
            fn($cmd, $key) => [
                'name' => $key,
                'type' => $cmd[0],
                'desc' => $cmd[1],
                'command' => $cmd[2],
                'command-type' => $cmd[3]
            ],
            $group,
            array_keys($group)
        ), $commands);
    }
}


