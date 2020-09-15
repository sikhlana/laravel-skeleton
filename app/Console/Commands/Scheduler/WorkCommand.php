<?php

namespace App\Console\Commands\Scheduler;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\PhpExecutableFinder;

class WorkCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scheduler:work';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start a worker that runs the scheduler every minute';

    protected $quit = false;

    /**
     * Execute the console command.
     *
     * @param PhpExecutableFinder $finder
     * @return int
     */
    public function handle(PhpExecutableFinder $finder)
    {
        $this->registerSignalHandler();
        $executable = $finder->find(false);

        do {
            $process = new Process([
                $executable,
                'artisan',
                'schedule:run',
            ], base_path());

            $process->start(function ($type, $data) {
                $this->getOutput()->write($data);
            });

            usleep(60000000);
        } while(! $this->quit);

        return 0;
    }

    protected function registerSignalHandler()
    {
        pcntl_async_signals(true);

        $handler = function () {
            $this->quit = true;

            exit(0);
        };

        pcntl_signal(SIGINT, $handler);
        pcntl_signal(SIGTERM, $handler);
    }
}
