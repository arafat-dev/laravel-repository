<?php

namespace Arafat\LaravelRepository\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class RepositoryCommand extends Command
{
    protected $signature = 'make:repository {name} {--model=}';

    protected $description = 'Create a new repository class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->line('');
        $this->info('🔨 Repository Generator');
        $this->line('-------------------------------------');

        $name = $this->argument('name');
        $modelName = $this->option('model');
        $className = Str::studly($name);

        // Table rows
        $rows = [
            ['📦 Repository Name', "<info>{$className}</info>"],
        ];

        if ($modelName) {
            $rows[] = ['🗂️  Using Model', "<comment>{$modelName}</comment>"];
        }

        $folderPath = app_path('Repositories');
        if (!file_exists($folderPath)) {
            mkdir($folderPath);
            $rows[] = ['📂 Created Folder', '<comment>app/Repositories</comment>'];
        }

        $repositoryPath = app_path("Repositories/{$className}.php");

        if (file_exists($repositoryPath)) {
            $this->error("❌ Repository already exists");
            $this->line("📍 Location: <comment>{$repositoryPath}</comment>");
            return 1;
        }

        // Prepare stub
        if ($modelName) {
            $modelVariable = Str::camel($modelName);
            $stub = file_get_contents(__DIR__ . '/../../stubs/repository.model.stub');
            if (file_exists(base_path('stubs/repository.model.stub'))) {
                $stub = file_get_contents(base_path('stubs/repository.model.stub'));
            }

            $stub = str_replace(
                ['{{ ClassName }}', '{{ modelName }}', '{{ modelVariable }}'],
                [$className, $modelName, $modelVariable],
                $stub
            );
        } else {
            $path = __DIR__ . '/../../stubs/repository.stub';
            $stub = file_get_contents($path);
            if (file_exists(base_path('stubs/repository.stub'))) {
                $stub = file_get_contents(base_path('stubs/repository.stub'));
            }
            $stub = str_replace('{{ ClassName }}', $className, $stub);
        }

        file_put_contents($repositoryPath, $stub);

        // Add success to table
        $rows[] = ['✅ Repository Created', "<comment>app/Repositories/{$className}.php</comment>"];

        // Print as table
        $this->table(
            ['Action', 'Details'],
            $rows
        );

        $this->newLine();
        $this->info('🎉 Done! Your repository is ready to use.');
        $this->newLine();

        return 0;
    }
}
