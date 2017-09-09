NAME=r.cfcr.io/anthonykgross/anthonykgross/streamplayer

build:
	docker build --file="Dockerfile" --tag="$(NAME):master" .

debug:
	docker-compose run streamplayer bash

run:
	docker-compose up
