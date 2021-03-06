# InfoPigeonSandbox
This was the first skeleton for the alpha version of InfoPigeon's web application, which just includes the networking functionality. This code came right out of the sandbox, so it is relatively unpolished and lacking in organization. My primary motivation for uploading this code was to illustrate the approaches to creating InfoPigeon's social network, while ensuring that the final closed-source product is satisfactorily distinct, as a result of significantly improved functionality and organization.

This project was run using XAMPP 7.2.30. The social network was a hybrid build, made with Elgg 2.3.14, an open-source social network engine, and customized plugins, with multiple of them coming from the Elgg community. A separate PHP user system was also created, in order to allow for future user functionality outside the scope of a social network. Furthermore, please note that users will not be able to reset their passwords in this local implementation.

------------------------------------------------------

In order to run this code, the following steps must be taken: 


1.) Download XAMPP: https://www.apachefriends.org/download.html


2.) Unzip the 'elgg' folder in XAMPP's ('htdocs/sites') folder. Also, unzip the 'mod' and 'vendor' subfolders (in '../elgg/elgg-2.3.14').


3.) Start XAMPP's Apache Web Server and SQL Database.


4.) Open a browser and go to: http://localhost/phpmyadmin/


5.) Create a database called "usersys" and create a table using command below:

"CREATE TABLE users (

idUsers int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
uidUsers TINYTEXT NOT NULL,
emailUsers TINYTEXT NOT NULL,
displaynameUsers TINYTEXT NOT NULL,
pwdUsers LONGTEXT NOT NULL
);"


NOTE: Since there is no password reset functionality in the local environment, we'll skip the step of creating the table in the SQL database for it.


6.) Navigate to the Elgg site ('http://localhost/sites/elgg/elgg-2.3.14/') and complete the indicated setup steps.


7.) Last but not least, log in as the administration, click the gear icon in the top right corner and navigate to Administration -> Plugins. From there make sure all plugins except the following ones are enabled: Bookmarks, Front Page Demo, Diagnostics, Embed, Tag Cloud, Web Services, and Data views for web services.









