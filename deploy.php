<?php
namespace Deployer;

require 'recipe/laravel.php';

set('bin/php', 'php8.1');
set('bin/composer', '{{bin/php}} $(which composer)');

// Project name
set('application', 'atlas');

// Project repository
set('repository', 'git@github.com:SlovakNationalGallery/atlas.sng.sk.git');

// Shared files/dirs between deploys
add('shared_dirs', ['resources/fonts']);

set('allow_anonymous_stats', false);

// Hosts
host('lab_sng@webumenia.sk')
    ->set('deploy_path', '/var/www/atlas.sng.sk')
    ->set('user', 'lab_sng');

// Tasks
task('build', function () {
    cd('{{release_path}}');

    run('source "$HOME/.nvm/nvm.sh" && nvm use 16.16.0 && npm ci && npm run build');
});

// Hooks
before('artisan:migrate', 'artisan:cache:clear');
after('deploy:vendors', 'build');
after('deploy:symlink', 'artisan:queue:restart');
after('deploy:failed', 'deploy:unlock');
