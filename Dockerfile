FROM php:latest

RUN apt-get update && apt-get install -y libzip-dev zlib1g-dev chromium wget gnupg lsof && docker-php-ext-install zip

RUN wget -q -O - https://dl-ssl.google.com/linux/linux_signing_key.pub | apt-key add -

RUN sh -c 'echo "deb [arch=amd64] http://dl.google.com/linux/chrome/deb/ stable main" >> /etc/apt/sources.list.d/google.list'

RUN apt-get update

RUN apt-get install -y google-chrome-stable

ENV PANTHER_NO_SANDBOX 1

# Not mandatory, but recommended
ENV PANTHER_CHROME_ARGUMENTS='--disable-dev-shm-usage'

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer self-update --snapshot

# Install sigmie crawler
RUN composer global require sigmie/crawler

# Make entrypoint and chrome driver executable
RUN chmod +x /root/.composer/vendor/sigmie/crawler/entrypoint.sh && \
    chmod +x /root/.composer/vendor/symfony/panther/chromedriver-bin/chromedriver_linux64

# Sigmie crawler command
ENTRYPOINT ["/root/.composer/vendor/sigmie/crawler/entrypoint.sh"]
