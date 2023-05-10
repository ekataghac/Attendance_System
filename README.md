The inital step to set up the docker file:

-   clone the git repository
-   move to the cloned repository from the terminal
-   Build up the docker composer using the command:
    docker-compose up --build -d
-   Seed up the database using the following command:
    docker exec attendanceAP-php-1 php artisan migrate:fresh --seed

\*note: until and unless you run the codes above the http://127.0.0.1:8000/ will not work

\*Note: env.example has the necessary database information.

After that try 'docker ps' command which will show the formed container, image, command,status, ports

-login with these credetials
Admin privilage
email: anchorpoint@gmail.com
password: password

Super admin privilage
OR
email: anchorpoint123@gmail.com
password: password

\*This command will help removing any images form the public/storage
Remove-Item public/storage -Recurse -Force
