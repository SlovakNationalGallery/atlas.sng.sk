<?php
namespace Deployer;

require 'recipe/laravel.php';
require 'contrib/npm.php';

set('bin/php', 'php8.1');
set('bin/composer', '{{bin/php}} $(which composer)');

// Project name
set('application', 'atlas');

// Project repository
set('repository', 'git@github.com:SlovakNationalGallery/atlas.sng.sk.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', ['storage', 'resources/fonts']);

// Writable dirs by web server
add('writable_dirs', []);
set('allow_anonymous_stats', false);

// Hosts

host('lab_sng@webumenia.sk')
    ->set('deploy_path', '/var/www/atlas.sng.sk')
    ->set('user', 'lab_sng');

// Tasks

task('build', function () {
    run('cd {{release_path}} && {{bin/npm}} run production');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');

after('deploy:update_code', 'npm:install');
after('deploy:shared', 'build');
