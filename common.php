<?php
namespace Deployer;

require 'recipe/common.php';

set('composer_deploy_path', "{{deploy_path}}");

// Tasks
desc('Git update code to pipeline version');
task('git:update-code', function(){

    // If option `tag` is not set and option `revision` is set
    if (input()->hasOption('revision')) {
        $revision = input()->getOption('revision');
    }

    cd('{{deploy_path}}');
    run('git fetch');

    if (!empty($revision)) {
        run("git checkout $revision");
    }
    else {
        run('git pull origin master');
    }
});

desc('Run composer install -o --no-dev on deploy_path');
task('composer:install-no-dev', function(){
    cd('{{composer_deploy_path}}');
    run('composer install -o --no-dev');
});