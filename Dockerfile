FROM php:8.2-cli
WORKDIR /app
COPY . /app
RUN php tests/run.php
CMD ["php", "index.php"]