<?php
namespace Deployer;

require 'recipe/common.php';

// Project name
set('application', 'peanut-stats');

// Project repository
set('repository', 'ssh://git@git.97866.com:22211/backend/peanut-stats.git');
set('branch', 'master');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', false);

// Shared files/dirs between deploys 
set('shared_files', []);
set('shared_dirs', ['var', 'config']);

// Writable dirs by web server 
set('writable_dirs', ['var']);

set('keep_releases', 5);

set('bin/php', function () {
	return '/opt/php7/bin/php';
});

// Hosts
host('43.241.235.171')
	->stage('production')
	->user('deployer')
	->port(22211)
	->configFile('~/.ssh/config')
	->identityFile('~/.ssh/peanut_deployer')
	->forwardAgent(true)
	->multiplexing(true)
	->addSshOption('UserKnownHostsFile', '/dev/null')
	->addSshOption('StrictHostKeyChecking', 'no')
	->stage('production')
	->set('deploy_path', '/data/www/{{application}}');

// Tasks

desc('Deploy your project');
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:writable',
    'deploy:vendors',
    'deploy:clear_paths',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'success'
]);

// [Optional] If deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

after('deploy:info', 'cron:stop');
before('success', 'cron:deploy');
after('deploy:vendors', 'composer:dumpautoload');

desc('composer:dumpautoload');
task('composer:dumpautoload', function (){
	run('cd {{release_path}} && composer dumpautoload');
});


// 部署cron job
desc('cron:stop');
task('cron:stop', function(){
	run('php /data/www/{{application}}/current/bin/console peanut:cron:stop');
});

desc('cron:deploy');
task('cron:deploy', function(){
	run('php /data/www/{{application}}/current/bin/console peanut:cron:deploy');
});