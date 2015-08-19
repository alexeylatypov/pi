# pi
Вычисление числа pi методом Монте-Карло

Сборка PHP для elastic Beanstalk
files:
 "/etc/php-5.6.d/project.ini":
    mode: "000644"
    owner: root
    group: root
    content: |
      session.save_handler = redis
      session.save_path = "tcp://repgroup.k7kayx.ng.0001.usw2.cache.amazonaws.com:6379"
# these commands run before the application and web server are
# set up and the application version file is extracted.
commands:
    01_php_install:
        # run this command from /tmp directory
        cwd: /tmp        
        test: '[ ! -f /etc/php.d/pthreads.ini ] && echo "pthreads not installed"'
        # executed only if test command succeeds
        command: |
            wget http://www.php.net/distributions/php-5.6.12.tar.gz \
            && tar zxvf php-5.6.12.tar.gz \
            && cd php-5.6.12 \
            && ./configure --prefix=/usr --with-config-file-path=/etc --enable-maintainer-zts \
            && make && make install \
            && pecl install pthreads \
            && echo "extension=pthreads.so" >> /etc/php-5.6.d/project.ini