<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'git@github.com:Athlee-TimeShare/TIME-SHARING-RESERVATION.git');

add('shared_files', []);
add('shared_dirs', [
    'vendor'
]);
add('writable_dirs', [
    'bootstrap/cache',
    'storage',
    ' | echo',
]);

set('writable_mode', "chmod");
set('writable_chmod_mode', "0777");

// Hosts

host('develop')
    ->setHostname('13.113.115.46')
    ->setRemoteUser('dev-tsr.adval.site')
    ->setDeployPath('~')
    ->set('branch', 'develop')
    ->set('keep_releases', 2)
    ->set('labels', ['env' => 'develop', 'name' => 'develop'])
    ->set('minimum_version', '0.0.0');
// host('staging')
//     ->set('remote_user', 'deployer')
//     ->set('deploy_path', '~/TIME-SHARING-RESERVATION');
// host('production')
//     ->set('remote_user', 'deployer')
//     ->set('deploy_path', '~/TIME-SHARING-RESERVATION');

desc('Deploy Application');
task('deploy:done', function () {
    run("cd {{release_path}} && npm install --legacy-peer-deps");
    run("cd {{release_path}} && npm run dev");
    run("cd {{release_path}} && php artisan key:generate");
});

desc('shared/.envを{stage}.envで上書き');
task('overwrite-env', function(){
    $host = get('branch');
    $targetEnv = "/env/$host.env";
    run("cp -f {{release_path}}$targetEnv ~/shared/.env");
});

// Hooks

after('deploy:failed', 'deploy:unlock');

before('deploy:shared', 'overwrite-env');
after('deploy:shared', 'deploy:done');
