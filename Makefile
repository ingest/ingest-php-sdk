phpdoc:
	vendor/bin/phpdoc -d ./src -t ./docs

dev:
	php -S localhost:8000 -t docs/

profile:
	php -dxdebug.profiler_enable=On -dxdebug.remote_enable=1 -dxdebug.remote_mode=req -dxdebug.remote_port=9099 -dxdebug.remote_host=127.0.0.1 vendor/phpunit/phpunit/phpunit -c phpunit.xml --stop-on-error

debug:
	php -dxdebug.remote_enable=1 -dxdebug.remote_mode=req -dxdebug.remote_port=9099 -dxdebug.remote_host=127.0.0.1 vendor/phpunit/phpunit/phpunit -c phpunit.xml --stop-on-error --stop-on-error

test:
	vendor/phpunit/phpunit/phpunit -c phpunit.xml --stop-on-error
