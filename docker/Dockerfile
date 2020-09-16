# :latest is the latest LTS
FROM ubuntu:latest

# Make all commands non-interactive, so they don't stop and wait for a response
ENV DEBIAN_FRONTEND=noninteractive

# Setup the timezone to UTC
RUN apt-get update \
    && apt-get install -y gnupg tzdata gosu \
    && gosu nobody true \
    && echo "UTC" > /etc/timezone \
    && dpkg-reconfigure -f noninteractive tzdata

# Install git, nginx, php, php extensions, composer, php-pcov (for faster code coverage), node, and yarn
RUN apt-get update \
    && apt-get -y install sudo software-properties-common \
    && add-apt-repository ppa:ondrej/php \
    && apt-get update \
    && apt-get install -y curl zip unzip git supervisor sqlite3 \
        nginx php7.4-fpm php7.4-cli php-pcov \
        php7.4-bcmath php7.4-curl php7.4-gd \
        php7.4-intl php7.4-mbstring php7.4-mysql \
        php7.4-sqlite3 php7.4-xdebug php7.4-xml php7.4-zip \
    && php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer \
    && curl -sL https://deb.nodesource.com/setup_12.x | sudo -E bash - \
    && curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - \
    && echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list \
    && apt-get update \
    && apt-get install -y nodejs yarn \
    # php uses the /run/php directory for temp files when running
    && mkdir /run/php \
    # cleanup packages that are not needed
    && apt-get -y autoremove \
    && apt-get clean \
    # remove apt repository lists that are not needed
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
    # turn off nginx's daemon mode (needed to work with supervisor)
    && echo "daemon off;" >> /etc/nginx/nginx.conf

# Make nginx log to stdout and stderr
RUN ln -sf /dev/stdout /var/log/nginx/access.log \
    && ln -sf /dev/stderr /var/log/nginx/error.log

# Add configuration files to the image
COPY site.nginx /etc/nginx/sites-available/default
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY php-fpm.conf /etc/php/7.4/fpm/php-fpm.conf
COPY php.ini /etc/php/7.4/fpm/conf.d/teleprompt.php.ini

# Add the container-started script to the image in `/usr/bin/` so it's in the path,
# and make the script executable
COPY container-started.sh /usr/bin/container-started
RUN chmod +x /usr/bin/container-started

# Create the `teleprompt` user with the password `secret`
RUN useradd -ms /bin/bash -u 1337 teleprompt \
    && echo teleprompt:secret | chpasswd

# Give the `teleprompt` user root privileges by adding to the sudo group
RUN usermod -aG sudo teleprompt

# Copy the custom bash config files
COPY .bash_aliases /home/teleprompt/.bash_aliases
COPY .bashrc /home/teleprompt/.teleprompt-bashrc

# Include the custom .bashrc file in the default one
RUN printf "\n# Use the teleprompt .bashrc file\n[ -f \"\$HOME/.teleprompt-bashrc\" ] && source \"\$HOME/.teleprompt-bashrc\"" >> /home/teleprompt/.bashrc

# On start, run the `/usr/bin/container-started` script to start
# supervisor, which will run nginx and php-fpm
ENTRYPOINT ["container-started"]
