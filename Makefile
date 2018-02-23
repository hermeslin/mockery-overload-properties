.PHONY: test
test:
	vendor/bin/phpunit --stderr --configuration 'phpunit.xml'