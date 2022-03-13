.PHONY: qa
qa: cs tests

.PHONY: cs
cs:
	.Build/bin/ecs check --fix

.PHONY: tests
tests:
	.Build/bin/phpunit --configuration=Tests/phpunit.xml.dist

.PHONY: zip
zip:
	grep -Po "(?<='version' => ')([0-9]+\.[0-9]+\.[0-9]+)" ext_emconf.php | xargs -I {version} sh -c 'mkdir -p ../zip; git archive -v -o "../zip/$(shell basename $(CURDIR))_{version}.zip" v{version}'
