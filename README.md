Clone your project
Go to the folder application using cd command on your cmd or terminal
Run composer install on your cmd or terminal (if you dont have composer installed , you get it here https://getcomposer.org/download/)
Copy .env.example file to .env on the root folder. You can type copy .env.example .env if using command prompt Windows or cp .env.example .env if using terminal, Ubuntu
Open your .env file and change the database name (DB_DATABASE) to whatever you have, username (DB_USERNAME) and password (DB_PASSWORD) field correspond to your configuration.
Run php artisan key:generate
Run php artisan migrate
Run php artisan serve
Go to http://localhost:8000/

End point http://127.0.0.1:8000/api/task
Post request data sample

{

    "filename": "myscript.sh",

    "tasks": [

        {

            "name": "rm",

            "command": "rm -f /tmp/test",

            "dependencies": [

                "cat"

            ]

        },

        {

            "name": "cat",

            "command": "cat /tmp/test",

            "dependencies": [

                "chown",

                "chmod"

            ]

        },
        
        {

            "name": "chown",

            "command": "chown root:root /tmp/test",

            "dependencies": [

                "touch"

            ]

        },

        {

            "name": "touch",

            "command": "touch /tmp/test"

        },

        {

            "name": "chmod",

            "command": "chmod 600 /tmp/test",

            "dependencies": [

                "touch"

            ]

        }

    ]

}
