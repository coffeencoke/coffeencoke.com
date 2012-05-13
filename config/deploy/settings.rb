set :application, "coffeencoke"
set :repository, "git@github.com:coffeencoke/coffeencoke.com"
set :branch, ENV['branch'] || "master"
set :deploy_via, :remote_cache
set :scm, :git
set :use_sudo, false
set :keep_releases, 3

