FROM anthonykgross/docker-fullstack-web:php5

MAINTAINER Anthony K GROSS

WORKDIR /src

ARG APPLICATION_ENV='prod'
ARG DB_BASE='DB_BASE'
ARG DB_USER='DB_USER'
ARG DB_MDP='DB_MDP'
ARG DB_HOST='DB_HOST'
ENV APPLICATION_ENV $APPLICATION_ENV

RUN apt-get update -y && \
	apt-get upgrade -y && \
	apt-get install -y supervisor nginx && \
    rm -rf /var/lib/apt/lists/* && \
    apt-get autoremove -y --purge

    
RUN rm -Rf /etc/php5/* && \
    rm -Rf /etc/supervisor/conf.d/* && \
    rm -Rf /etc/nginx/* && \
    rm -Rf /src/* && \
    rm -Rf /logs/*
    
COPY entrypoint.sh /entrypoint.sh
COPY conf/php5 /etc/php5
COPY conf/supervisor /etc/supervisor/conf.d
COPY conf/nginx /etc/nginx
COPY src /src
COPY logs /logs

RUN if [ "$APPLICATION_ENV" = "prod" ]; then \
        cp -f /src/config.php.prod /src/config.php && \
        sed -i -e "s,\${{DB_BASE}},$DB_BASE,g" /src/config.php && \
        sed -i -e "s,\${{DB_USER}},$DB_USER,g" /src/config.php && \
        sed -i -e "s,\${{DB_MDP}},$DB_MDP,g" /src/config.php && \
        sed -i -e "s,\${{DB_HOST}},$DB_HOST,g" /src/config.php \
    ; fi

RUN chmod +x /entrypoint.sh && \
    bash --rcfile "/root/.bash_profile" -ic "/entrypoint.sh install"

EXPOSE 80
EXPOSE 443

ENTRYPOINT ["/entrypoint.sh"]
CMD ["run"]