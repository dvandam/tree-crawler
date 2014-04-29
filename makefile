SHA:=$(shell git rev-parse HEAD)
COMMIT_DATE:=$(shell git log --date=iso -1 --format=%cd)
PHPUNIT_LOG:=$(SHA).xml
TARGET_DIRECTORY:=TARGET_DIRECTORY/$(SHA)
BUILD:=build/$(SHA)

$(BUILD): $(PHPUNIT_LOG)
	composer install --no-dev
	mkdir -p build
	box build
	mv build/program.phar $(BUILD)
	chmod +x $(BUILD)
	cp $(BUILD) build/program

$(PHPUNIT_LOG): vendor/bin/phpunit $(TARGET_DIRECTORY)
	vendor/bin/phpunit --colors --log-junit $(PHPUNIT_LOG) $(TARGET_DIRECTORY)/tests
	touch -d "$(COMMIT_DATE)" $(PHPUNIT_LOG)

$(TARGET_DIRECTORY):
	if [ ! -d $(TARGET_DIRECTORY)/vendor ]; then mkdir -p $(TARGET_DIRECTORY)/vendor \
	&& git archive HEAD | tar -x -C $(TARGET_DIRECTORY) \
	&& cp -r vendor/* $(TARGET_DIRECTORY)/vendor \
	&& find $(TARGET_DIRECTORY) -exec touch -d "$(COMMIT_DATE)" {} \; ; \
	fi

.PHONY: test
test: vendor/bin/phpunit
	vendor/bin/phpunit --colors tests

vendor/bin/phpunit:
	composer install
	find vendor -exec touch -d "$(COMMIT_DATE)" {} \; \

.PHONY: clean
clean:
	rm -rf TARGET_DIRECTORY
