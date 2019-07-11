# php-registration

A register with email verification and login system with bootstrap 4

## Prerequisites
#### MySql Server
Table  **users**
- id `PRIMARY KEY`
- username `VARCHAR`
- email `VARCHAR + UNIQUE`
- password `VARCHAR`
- verified `VARCHAR`
- token `TINYINT`