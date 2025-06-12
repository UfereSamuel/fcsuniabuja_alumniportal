<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class ServerStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fcs:status {--json : Output as JSON}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show status of running Laravel development servers';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $runningServers = $this->findRunningLaravelServers();
        $json = $this->option('json');

        if ($json) {
            $this->line(json_encode($runningServers, JSON_PRETTY_PRINT));
            return 0;
        }

        if (empty($runningServers)) {
            $this->info('✅ No running Laravel servers found.');
            $this->line('');
            $this->info('Start a server with: php artisan fcs:serve');
            return 0;
        }

        $this->info('🚀 Running Laravel Servers:');
        $this->line('');

        foreach ($runningServers as $index => $server) {
            $this->line("  📍 Server " . ($index + 1));
            $this->line("     URL: {$server['url']}");
            $this->line("     Host: {$server['host']}");
            $this->line("     Port: {$server['port']}");
            $this->line("     PID: {$server['pid']}");
            $this->line("     Uptime: {$server['uptime']}");
            $this->line('');
        }

        $this->info('Commands:');
        $this->line('  • Stop specific: php artisan fcs:stop --port=8000');
        $this->line('  • Stop all: php artisan fcs:stop --all');
        $this->line('  • Start new: php artisan fcs:serve --port=8001');

        return 0;
    }

    /**
     * Find running Laravel development servers
     */
    private function findRunningLaravelServers(): array
    {
        $servers = [];

        if (PHP_OS_FAMILY !== 'Windows') {
            $process = new Process(['pgrep', '-f', 'artisan serve']);
            $process->run();

            if ($process->getExitCode() === 0) {
                $pids = array_filter(explode("\n", trim($process->getOutput())));

                foreach ($pids as $pid) {
                    $cmdProcess = new Process(['ps', '-p', $pid, '-o', 'args=,lstart=']);
                    $cmdProcess->run();

                    if ($cmdProcess->getExitCode() === 0) {
                        $output = trim($cmdProcess->getOutput());
                        $lines = explode("\n", $output);

                        if (count($lines) >= 2) {
                            $command = trim($lines[1]);
                            if (strpos($command, 'artisan serve') !== false) {
                                // Extract host and port from command
                                preg_match('/--host[=\s]+([^\s]+)/', $command, $hostMatch);
                                preg_match('/--port[=\s]+([^\s]+)/', $command, $portMatch);

                                $host = $hostMatch[1] ?? '127.0.0.1';
                                $port = $portMatch[1] ?? '8000';

                                // Get process start time
                                $uptime = $this->getProcessUptime($pid);

                                $servers[] = [
                                    'pid' => $pid,
                                    'host' => $host,
                                    'port' => $port,
                                    'url' => "http://{$host}:{$port}",
                                    'uptime' => $uptime,
                                ];
                            }
                        }
                    }
                }
            }
        }

        return $servers;
    }

    /**
     * Get process uptime
     */
    private function getProcessUptime($pid): string
    {
        if (PHP_OS_FAMILY !== 'Windows') {
            $process = new Process(['ps', '-p', $pid, '-o', 'etime=']);
            $process->run();

            if ($process->getExitCode() === 0) {
                $etime = trim($process->getOutput());
                return $etime ?: 'Unknown';
            }
        }

        return 'Unknown';
    }
}
