FROM nginx:latest

COPY /docker/prod/nginx/nginx-site.conf /etc/nginx/conf.d/default.conf

COPY ./public /code/public

EXPOSE 80
EXPOSE 443
ENTRYPOINT nginx -g 'daemon off;'