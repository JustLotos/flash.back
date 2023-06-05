FROM node:14-alpine


RUN apk add --update --no-cache make

ENV PYTHONUNBUFFERED=1
RUN apk add --update --no-cache python3 && ln -sf python3 /usr/bin/python
RUN python3 -m ensurepip
RUN pip3 install --no-cache --upgrade pip setuptools

RUN apk add --update sudo \
		     yarn
RUN yarn add --dev @symfony/webpack-encore

USER appuser

WORKDIR /app
