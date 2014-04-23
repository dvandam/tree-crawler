.PHONY: build
build: test clean archive-source
	mkdir -p build
	box build
	mv build/program.phar build/program
	chmod +x build/program
	rm -rf target

.PHONY: test
test: install-dev
	vendor/bin/phpunit --colors tests

.PHONY: install-dev
install-dev:
	composer install

.PHONY: clean
clean:
	composer install --no-dev
	rm -rf target

.PHONY: archive-source
archive-source:
	mkdir -p target/vendor
	git archive HEAD | tar -x -C target
	cp -r vendor/* target/vendor
