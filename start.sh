#!/bin/bash

# Create PHP configuration file
cat > php.ini << EOL
allow_url_include = On
allow_url_fopen = On
extension=expect.so
EOL

# Start PHP server with custom configuration
php -S localhost:5555 -c php.ini
