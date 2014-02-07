CREATE USER 'limba'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON limba.* TO 'limba'@'localhost' WITH GRANT OPTION;
FLUSH PRIVILEGES;