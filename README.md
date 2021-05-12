# About 

    Authentication API using XAMPP, MySQL, OOP and MVC patterns

# Pre configs

    The mail() function may need some pre-settings

        **on file /xamp/php/php.ini**
        
        [mail function]

            - extension = mysqli

            - sendmail_from = seuemail@gmail.com

            - sendmail_path = "C:\xampp\sendmail\sendmail.exe -t"

        **on file /xamp/sendmail/sendmail.ini**

        [sendmail]

            - smtp_server = smtp.gmail.com
            
            - smtp_port = 465 
        
            - smtp_ssl = sll
        
            - auth_username = seuemail@gmail.com
            
            - auth_password = senhadoseuemail123
        
            - hostname = localhost
