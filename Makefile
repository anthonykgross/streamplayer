NAME=r.cfcr.io/anthonykgross/anthonykgross/streamplayer

build:
	docker build --file="Dockerfile" --tag="$(NAME):master" .

debug:
	docker run -it --rm --entrypoint=/bin/bash $(NAME):master

run:
	docker-compose up