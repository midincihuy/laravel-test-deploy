@servers(['web' => 'mailnidimah_hamidin@35.240.200.94'])
@setup
    $repository = 'git@gitlab.com:midincihuy/laravel-test-deploy.git';
    $releases_dir = '/home/mailnidimah_hamidin/workspace/php/releases';
    $app_dir = '/home/mailnidimah_hamidin/workspace/php';
    $release = date('YmdHis');
    $new_release_dir = $releases_dir .'/'. $release;
@endsetup
@story('deploy')
    clone_repository
    run_composer
    update_symlinks
    migrate
@endstory
@task('clone_repository')
    echo 'Cloning repository'
    [ -d {{ $releases_dir }} ] || mkdir {{ $releases_dir }}
    git clone --depth 1 {{ $repository }} {{ $new_release_dir }}
    echo 'Done'
@endtask
@task('run_composer')
    echo "Starting deployment ({{ $release }})"
    cd {{ $new_release_dir }}
    composer update
    echo 'Done'
@endtask
@task('update_symlinks')
    echo "Linking storage directory"
    rm -rf {{ $new_release_dir }}/storage
    ln -nfs {{ $app_dir }}/storage {{ $new_release_dir }}/storage
    echo 'Done'
echo 'Linking .env file'
    ln -nfs {{ $app_dir }}/.env {{ $new_release_dir }}/.env
    echo 'Done'
echo 'Linking current release'
    ln -nfs {{ $new_release_dir }} {{ $app_dir }}/current
    echo 'Done'
@endtask
@task('migrate')
  echo "start migrating"
  /usr/bin/php {{ $app_dir }}/current/artisan migrate
  echo "done migrating"
@endtask