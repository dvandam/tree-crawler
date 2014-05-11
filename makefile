SHA:=$(shell git rev-parse --short HEAD)
COMMIT_DATE:=$(shell git log --date=iso -1 --format=%cd)
PHPUNIT_LOG:=test-results-$(SHA).xml
TARGET_DIRECTORY:=target/$(SHA)
BUILD:=build/$(SHA)

$(BUILD): $(PHPUNIT_LOG)
	mkdir -p build
	box build
	mv build/program.phar $(BUILD)
	chmod +x $(BUILD)
	cp $(BUILD) build/program

$(PHPUNIT_LOG): $(TARGET_DIRECTORY) vendor/bin/phpunit 
	vendor/bin/phpunit --colors --log-junit $(PHPUNIT_LOG) $(TARGET_DIRECTORY)/tests
	touch -d "$(COMMIT_DATE)" $(PHPUNIT_LOG)

$(TARGET_DIRECTORY):
	if [ ! -d $(TARGET_DIRECTORY)/vendor ]; then mkdir -p $(TARGET_DIRECTORY)/vendor \
	&& composer install --no-dev \
	&& git archive HEAD | tar -x -C $(TARGET_DIRECTORY) \
	&& cp -r vendor/* $(TARGET_DIRECTORY)/vendor \
	&& find $(TARGET_DIRECTORY) -exec touch -d "$(COMMIT_DATE)" {} \; \
	&& rm -rf target/archive \
	&& ln -s $(SHA) target/archive; \
	fi

.PHONY: test
test: vendor/bin/phpunit
	vendor/bin/phpunit --colors tests

vendor/bin/phpunit:
	composer install
	find vendor -exec touch -d "$(COMMIT_DATE)" {} \;

.PHONY: clean
clean:
	rm -rf target
	composer install --no-dev

.PHONY clean-all:
clean-all: clean
	rm -rf build
	git clean -f
