<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class StopServerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fcs:stop {--all : Stop all running Laravel servers} {--port= : Stop server on specific port}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Stop running Laravel development servers';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $all = $this->option('all');
        $port = $this->option('port');

        if ($port) {
            return $this->stopServerOnPort($port);
        }

        if ($all) {
            return $this->stopAllServers();
        }

        // Show running servers and let user choose
        $runningServers = $this->findRunningLaravelServers();

        if (empty($runningServers)) {
            $this->info('✅ No running Laravel servers found.');
            return 0;
        }

        $this->info('Found running Laravel servers:');
        foreach ($runningServers as $index => $server) {
            $this->line("  {$index}. {$server['display']}");
        }
        $this->line('');

        $choice = $this->choice(
            'Which server would you like to stop?',
            array_merge(['All servers', 'Cancel'], array_column($runningServers, 'display')),
            'Cancel'
        );

        if ($choice === 'Cancel') {
            $this->info('Operation cancelled.');
            return 0;
        }

        if ($choice === 'All servers') {
            return $this->stopAllServers();
        }

        // Find and stop the selected server
        foreach ($runningServers as $server) {
            if ($server['display'] === $choice) {
                return $this->stopServerByPid($server['pid']);
            }
        }

        return 0;
    }

    /**
     * Stop server on specific port
     */
    private function stopServerOnPort($port): int
    {
        if (PHP_OS_FAMILY !== 'Windows') {
            $process = new Process(['lsof', '-ti', ":{$port}"]);
            $process->run();

            if ($process->getExitCode() === 0) {
                $pid = trim($process->getOutput());
                if ($pid) {
                    return $this->stopServerByPid($pid);
                }
            }
        }

        $this->error("No server found running on port {$port}");
        return 1;
    }

    /**
     * Stop all Laravel servers
     */
    private function stopAllServers(): int
    {
        $runningServers = $this->findRunningLaravelServers();

        if (empty($runningServers)) {
            $this->info('✅ No running Laravel servers found.');
            return 0;
        }

        $this->info('Stopping all Laravel servers...');

        $stopCount = 0;
        foreach ($runningServers as $server) {
            if ($this->stopServerByPid($server['pid'], false)) {
                $stopCount++;
            }
        }

        if ($stopCount > 0) {
            $this->info("✅ Stopped {$stopCount} server(s).");
        } else {
            $this->warn('⚠️  No servers were stopped.');
        }

        return 0;
    }

    /**
     * Stop server by PID
     */
    private function stopServerByPid($pid, $showMessage = true): bool
    {
        if (PHP_OS_FAMILY !== 'Windows') {
            $process = new Process(['kill', $pid]);
            $process->run();

            if ($process->getExitCode() === 0) {
                if ($showMessage) {
                    $this->info("✅ Server stopped (PID: {$pid})");
                }
                return true;
            } else {
                if ($showMessage) {
                    $this->error("❌ Failed to stop server (PID: {$pid})");
                }
                return false;
            }
        }

        return false;
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
                    $cmdProcess = new Process(['ps', '-p', $pid, '-o', 'args=']);
                    $cmdProcess->run();

                    if ($cmdProcess->getExitCode() === 0) {
                        $command = trim($cmdProcess->getOutput());
                        if (strpos($command, 'artisan serve') !== false) {
                            // Extract host and port from command
                            preg_match('/--host[=\s]+([^\s]+)/', $command, $hostMatch);
                            preg_match('/--port[=\s]+([^\s]+)/', $command, $portMatch);

                            $host = $hostMatch[1] ?? '127.0.0.1';
                            $port = $portMatch[1] ?? '8000';

                            $servers[] = [
                                'pid' => $pid,
                                'host' => $host,
                                'port' => $port,
                                'display' => "http://{$host}:{$port} (PID: {$pid})"
                            ];
                        }
                    }
                }
            }
        }

        return $servers;
    }
}
