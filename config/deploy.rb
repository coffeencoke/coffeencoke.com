# Colorize output, if we have the colorizing extension.
begin
  require 'capistrano_colors'
rescue LoadError
  nil
end

$:.unshift(File.expand_path('./lib', ENV['rvm_path'])) # Add RVM's lib directory to the load path.
require "rvm/capistrano" # Load RVM's capistrano plugin.

set :rvm_ruby_string,     '1.9.2@coffeencoke' # Or whatever env you want it to run in.
set :rvm_type,            :user

require 'bundler/capistrano'

set :bundle_flags,        "--deployment" # Disable the --quiet that is set by default.
set :bundle_without,      [:development, :test, :cucumber]
set :rake,                "bundle exec rake"
set :keep_releases,       2
set :application,         'coffeencoke'
set :user,                'msimpson'
set :deploy_to,           '/var/www/coffeencoke.com'
set :use_sudo,            false
set :repository,          '.'
set :scm,                 :git
set :deploy_via,          :remote_cache
set :branch, ENV['BRANCH'] || ENV['branch'] || 'master'


#server 'demo.bondstor.com', :app, :web, :db, :primary => true
server 'osriver.boochtek.com', :app, :web, :db, :primary => true

def execute_rake_task(task, options = '')
  rake = fetch(:rake, "rake")
  run "cd #{release_path}; #{rake} #{task} #{options}"
end

def execute_rake_task_background(task, options = '')
  execute_rake_task task, options + " &"
end

namespace :deploy do
  task :start, :roles => :app, :except => {:no_release => true} do
    #execute_rake_task 'unicorn:start', "environment=#{rails_env}"
  end
  task :stop, :roles => :app, :except => {:no_release => true} do
    #execute_rake_task 'unicorn:stop'
  end
  task :graceful_stop, :roles => :app, :except => {:no_release => true} do
    #execute_rake_task 'unicorn:graceful_stop'
  end
  task :restart, :roles => :app, :except => {:no_release => true} do
    #execute_rake_task 'unicorn:reload', "environment=#{rails_env}"
  end
end

after 'deploy:symlink', 'deploy:migrate'
after 'deploy:symlink', 'deploy:cleanup'
