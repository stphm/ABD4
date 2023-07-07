FROM caddy:2-builder-alpine AS caddy_proxy_builder

RUN xcaddy build \
	--with github.com/dunglas/mercure \
	--with github.com/dunglas/mercure/caddy \
	--with github.com/dunglas/vulcain \
	--with github.com/dunglas/vulcain/caddy \
    --with github.com/lucaslorentz/caddy-docker-proxy/v2 \
	--output /data/caddy
	

# caddy-docker-proxy image
FROM lucaslorentz/caddy-docker-proxy:ci-alpine AS caddy_proxy

WORKDIR /srv/app

COPY --from=caddy_proxy_builder /data/caddy /usr/bin/caddy