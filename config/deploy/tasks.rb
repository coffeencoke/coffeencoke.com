namespace :custom do
  desc 'symlink the custom files for this app'
  task :symlink, :roles => :app do
    run "ln -nfs #{shared_path}/uploads #{release_path}/public/wp-content/uploads"
    run "ln -nfs #{shared_path}/wp-config.php #{release_path}/public/"    
  end
end

after "deploy:symlink", "custom:symlink"

