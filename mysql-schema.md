### Database name
    
    mvc_php_api;

### Users table
```
    create table users(
        user_id int auto_increment primary key,
        username varchar(30),
        password varchar(32),
        email varchar(50),
        reset_password_token varchar(50),
        reset_password_token_expires datetime,
        user_image varchar(50),
    );
```

