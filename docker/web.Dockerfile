FROM nginx:alpine

ADD ./docker-compose/nginx/conf.d/app.conf /etc/nginx/conf.d/app.conf
WORKDIR /var/www

CMD ["nginx", "-g", "daemon off;"]