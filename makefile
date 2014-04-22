.PHONY: build
build: test clean

.PHONY: test
test: install-dev
	vendor/bin/phpunit --colors tests

.PHONY: install-dev
install-dev:
	composer install

.PHONY: clean
clean:
	composer install --no-dev
