<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class ServeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fcs:serve {--host=127.0.0.1 : The host address to serve the application on} {--port=8000 : The port to serve the application on} {--force : Force start even if another server is running}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Serve the FCS application with server conflict detection';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $host = $this->option('host');
        $port = $this->option('port');
        $force = $this->option('force');

        // Check if there's already a server running on this port
        if (!$force && $this->isPortInUse($port)) {
            $this->error("⚠️  A server is already running on port {$port}!");

            // Try to find the process details
            $processInfo = $this->getProcessOnPort($port);
            if ($processInfo) {
                $this->warn("Running process: {$processInfo}");
            }

            $this->line('');
            $this->info('Options:');
            $this->line('1. Stop the existing server first');
            $this->line('2. Use a different port: php artisan fcs:serve --port=8001');
            $this->line('3. Force start anyway: php artisan fcs:serve --force');
            $this->line('');

            return 1;
        }

        // Check if there are any Laravel servers running on other ports
        if (!$force) {
            $runningServers = $this->findRunningLaravelServers();
            if (!empty($runningServers)) {
                $this->warn('⚠️  Found existing Laravel server(s):');
                foreach ($runningServers as $server) {
                    $this->line("   • {$server}");
                }
                $this->line('');

                if (!$this->confirm('Do you want to continue starting another server?', false)) {
                    $this->info('Server start cancelled.');
                    return 0;
                }
            }
        }

        // Start the server
        $this->info("Starting FCS Alumni Portal server...");
        $this->info("Server: http://{$host}:{$port}");
        $this->info("Press Ctrl+C to stop the server");
        $this->line('');

        // Call the original serve command
        $exitCode = $this->call('serve', [
            '--host' => $host,
            '--port' => $port,
        ]);

        return $exitCode;
    }

    /**
     * Check if a port is in use
     */
    private function isPortInUse($port): bool
    {
        // For macOS/Linux
        if (PHP_OS_FAMILY !== 'Windows') {
            $process = new Process(['lsof', '-ti', ":{$port}"]);
            $process->run();
            return $process->getExitCode() === 0;
        }

        // For Windows
        $process = new Process(['netstat', '-an']);
        $process->run();
        $output = $process->getOutput();

        return strpos($output, ":{$port} ") !== false;
    }

    /**
     * Get process information for a specific port
     */
    private function getProcessOnPort($port): ?string
    {
        if (PHP_OS_FAMILY !== 'Windows') {
            $process = new Process(['lsof', '-ti', ":{$port}"]);
            $process->run();

            if ($process->getExitCode() === 0) {
                $pid = trim($process->getOutput());
                if ($pid) {
                    $processInfo = new Process(['ps', '-p', $pid, '-o', 'comm=']);
                    $processInfo->run();
                    return trim($processInfo->getOutput()) . " (PID: {$pid})";
                }
            }
        }

        return null;
    }

    /**
     * Find running Laravel development servers
     */
    private function findRunningLaravelServers(): array
    {
        $servers = [];

        if (PHP_OS_FAMILY !== 'Windows') {
            // Look for php processes that contain 'artisan serve' or 'php -S'
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

                            $servers[] = "http://{$host}:{$port} (PID: {$pid})";
                        }
                    }
                }
            }
        }

        return $servers;
    }
}
