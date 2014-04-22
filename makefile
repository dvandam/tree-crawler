.PHONY: test
test: install-dev
	vendor/bin/phpunit tests

.PHONY: install-dev
install-dev:
	composer install
