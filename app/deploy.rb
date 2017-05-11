set :application, 'gethired'
set :repo_url, '#'

set :deploy_to, '/home/gethired/'

set :archive_cache, true
set :branch, 'master'
set :scm, :rsync
set :exclude, ['.git', 'node_modules', 'web/app_dev.php']

set :linked_files, fetch(:linked_files, []).push('app/config/parameters.yml')
set :linked_dirs, fetch(:linked_dirs, []).push('var/logs').push('web/img/profiles').push('web/files/cv)'