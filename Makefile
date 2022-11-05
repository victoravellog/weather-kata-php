install:
	composer install

.PHONY: tests
tests:
	./vendor/bin/phpunit --debug

complexity:
	./vendor/bin/phpmetrics src/
