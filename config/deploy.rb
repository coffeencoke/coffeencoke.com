unless ENV['nocolor']
  begin
    require 'capistrano_colors'
  rescue LoadError
    nil
  end
end

load "config/deploy/settings"
load "config/deploy/tasks"

task :production do
  server 'osriver.boochtek.com', :app, :web, :db, :primary => true, :unicorn => true
  set :user, 'msimpson'
  set :deploy_to, "/var/www/coffeencoke.com"
end

