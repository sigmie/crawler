FROM php:latest

LABEL org.opencontainers.image.source https://github.com/sigmie/crawler

# Install packages and enable php zip extension
RUN apt-get update && apt-get install -y libzip-dev zlib1g-dev chromium wget gnupg lsof && docker-php-ext-install zip

# Install google chrome
RUN wget -q -O - https://dl-ssl.google.com/linux/linux_signing_key.pub | apt-key add - && \
    sh -c 'echo "deb [arch=amd64] http://dl.google.com/linux/chrome/deb/ stable main" >> /etc/apt/sources.list.d/google.list' && \
    apt-get update && \
    apt-get install -y google-chrome-stable

# Set pather sandbox flag
ENV PANTHER_NO_SANDBOX 1

# Not mandatory, but recommended
ENV PANTHER_CHROME_ARGUMENTS='--disable-dev-shm-usage'

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer self-update --snapshot

# Install sigmie crawler
RUN composer global require sigmie/crawler

# Make entrypoint and chrome driver executable
RUN chmod +x /root/.config/composer/vendor/sigmie/crawler/entrypoint.sh && \
    chmod +x /root/.config/composer/vendor/sigmie/crawler/drivers/chromedriver

RUN /root/.config/composer/vendor/bin/bdi detect drivers

# Sigmie crawler command
ENTRYPOINT ["/root/.config/composer/vendor/sigmie/crawler/entrypoint.sh"]
