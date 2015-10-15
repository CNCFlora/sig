FROM cncflora/apache

ADD . /var/www/
RUN chown www-data.www-data /var/www/ -Rf

