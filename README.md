Менеджер задач для производства. Интеграция с 1С и канбаном (kanboard.net) 

    git clone https://github.com/jerrygacket/workshop-manager.git
    cd workshop-manager
    composer install
    -- make config/db_local.php with your db config
    php yii migrate
    -- setup virtual host with server_root = project_dir/web
    -- go to http://virtualhostname and you see a login form if everything is ok

demo users:

    admin Doo3Wo
    demo 123
