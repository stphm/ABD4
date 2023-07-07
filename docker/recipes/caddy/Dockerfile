FROM caddy:2-builder-alpine AS caddy_server_builder

RUN xcaddy build \
	--with github.com/dunglas/mercure \
	--with github.com/dunglas/mercure/caddy \
	--with github.com/dunglas/vulcain \
	--with github.com/dunglas/vulcain/caddy

# caddy image
FROM caddy:2.6.4-alpine AS caddy_server

WORKDIR /srv/app

COPY --from=caddy_server_builder /usr/bin/caddy /usr/bin/caddy